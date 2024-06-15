<?php

namespace App\Livewire\AdminDashboard;

use App\Models\User;
use App\Models\Classe;
use App\Models\Module;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\Department;
use Livewire\Attributes\On;
use App\Models\ClassTeacher;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfesseurProfile extends Component
{
    use WithFileUploads;

    public $user;
    public $teacher;
    public $techerClasses;
    public $allClasses;
    public $teacherExams;
    public $classe;
    public $addClassModal = false;
    // public $editModuleModal = false;
    // public $departments;
    // public $selectedDepartment = null;
    // public $allModules;
    // public $selectedModule;

    public $editing;
    public $deleting;

    public $name;
    public $photo;
    public $email;
    public $phone;
    public $CIN;
    public $diplome;
    public $newClasse;

    #[Validate('required', message: "Veuillez saisir votre mot de passe")]
    public $adminPassword;

    public function mount($id)
    {
        //!! Retrieve all teachers associated with a class:
        //  $class = Classe::find($classId);
        // $teachers = $class->teachers;

        // !! Retrieve all classes associated with a teacher:
        // $teacher = Teacher::find($teacherId);
        // $classes = $teacher->classes;

        //!! Attach/Detach a teacher to a class:
        // $class = Classe::find(5);
        // $teacher = Teacher::find(21);
        // $class->teachers()->detach($teacher->id);
        // $class->teachers()->attach($teacher->id);

        $this->user = User::findOrFail($id);
        $this->teacher = Teacher::where('user_id', $this->user->id)->first();
        $this->allClasses = Classe::all();
        $this->teacherExams = $this->teacher->exams;
        $this->departments = Department::all();
        $this->fetchClasses();

        $this->photo = $this->teacher->user->photo;
        $this->name = $this->teacher->user->name;
        $this->email = $this->teacher->user->email;
        $this->phone = $this->teacher->user->phone;
        $this->CIN = $this->teacher->CIN;
        $this->diplome = $this->teacher->diploma;
        $this->editing = false;
        $this->deleting = false;
        // dd($this->techerClasses);
    }

    public function render()
    {
        return view('livewire.admin-dashboard.professeur-profile', [
            'user' => $this->user,
            'teacherModule' => Module::find($this->teacher->module_id),
            'classes' => $this->techerClasses,
            'allClasses' => $this->allClasses,
            'exams' => $this->teacherExams,
            // 'modules' => Module::where('id', $this->teacher->id)->get(),
        ]);
    }

    public function editTeacher()
    {
        // dd($this->name);

        $this->validate([
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:1024',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'CIN' => 'required|string|min:6|max:8',
            // 'password' => 'nullable|string|min:8|max:255',
            'diplome' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255|min:10',
        ], [
            'photo.mimes' => 'Le fichier doit être de type JPG, JPEG ou PNG.',
            'photo.max' => 'Le fichier ne doit pas dépasser 1 Mo.',
            'name.required' => 'Le nom est obligatoire.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.max' => 'L\'email ne doit pas dépasser 255 caractères.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'CIN.required' => 'Le CIN est obligatoire.',
            'CIN.max' => 'Le CIN ne doit pas dépasser 8 caractères.',
            'CIN.min' => 'Le CIN doit avoir au moins 6 caractères.',
            // 'password.required' => 'Le mot de passe est obligatoire.',
            // 'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            // 'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            // 'password.max' => 'Le mot de passe ne doit pas dépasser 255 caractères.',
            'diplome.required' => 'Le diplome est obligatoire.',
            'diplome.max' => 'Le diplome ne doit pas dépasser 255 caractères.',
            'phone.string' => 'Le champ téléphone doit être une chaîne de caractères.',
            'phone.min' => 'Le champ téléphone doit contenir au moins 10 caractères.',
            'phone.max' => 'Le champ téléphone ne doit pas dépasser 255 caractères.',
        ]);

        try {
            $this->teacher->user->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                // 'password' => Hash::make($this->password),
            ]);

            if ($this->photo) {
                $this->teacher->user->updateProfilePhoto($this->photo, $this->teacher->user->id);
            }

            $this->teacher->update([
                'CIN' => $this->CIN,
                'diploma' => $this->diplome,
            ]);
            $this->cancelEditing();
            Toaster::success('Professeur a bien été modifié');
        } catch (\Throwable $th) {
            throw $th;
            Toaster::error('Une erreur est servenu');
        }
    }

    public function cancelEditing()
    {
        $this->resetErrorBag();
        $this->mount($this->teacher->user->id);
    }

    public function deleteProfilePhoto()
    {
        $this->teacher->user->deleteProfilePhoto($this->teacher->user);
    }

    public function deleteTeacher()
    {
        $user = Auth::user();
        $this->validateOnly('adminPassword');
        try {
            if (password_verify($this->adminPassword, $user->password)) {
                $this->deleteProfilePhoto();

                $this->teacher->user->delete();

                $this->reset('deleting');
                Redirect::route('professeurs')
                    ->success('Professeur a bien été supprimeé.');
            } else {
                $this->addError('adminPassword', 'Le mot de passe est incorrect.');
            }

        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
    }

    #[On('getClasses')]
    public function fetchClasses()
    {
        $this->techerClasses = $this->teacher->classes;
    }

    public function addClass()
    {
        $this->validate([
            'classe' => 'required|integer|exists:classes,id',
        ], [
            'classe.required' => 'Vous devez sélectionner une classe.',
            'classe.integer' => 'La valeur sélectionnée doit être un nombre entier.',
            'classe.exists' => 'La classe sélectionnée n\'existe pas.',
        ]);
        ClassTeacher::create([
            'teacher_id' => $this->teacher->id,
            'classe_id' => $this->classe,
        ]);
        $this->reset('classe');
        $this->reset('addClassModal');
        // Emit an event to notify the component that a new class has been added
        $this->dispatch('getClasses');
        Toaster::success('Classe a bien été affectee');
    }

    public function deleteClasse($classe_id)
    {
        ClassTeacher::where('classe_id', $classe_id)
            ->where('teacher_id', $this->teacher->id)
            ->delete();

        $this->dispatch('getClasses');
        Toaster::success('supprimé avec succes');
    }
}
