<?php

namespace App\Livewire\AdminDashboard;

use App\Models\Exam;
use App\Models\User;
use App\Models\Classe;
use App\Models\Student;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;
use App\Jobs\SendPasswordEmail;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class EtudiantProfile extends Component
{
    use WithFileUploads;

    public $etudiant;
    public $exams;
    public $classes;

    public $editing;
    public $deleting;

    public $name;
    public $photo;
    public $email;
    public $phone;
    public $CNE;
    public $classe;
    public $newClasse;

    #[Validate('required', message: "Veuillez saisir votre mot de passe")]
    public $adminPassword;

    public function mount($id)
    {
        $user = User::findOrFail($id);
        $this->etudiant = Student::where('user_id', $user->id)->first();
        $this->exams = Exam::where("classe_id", $this->etudiant->classe_id)->get();
        $this->classes = Classe::all();

        $this->photo = $user->photo;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->CNE = $this->etudiant->CNE;
        $this->classe = $this->etudiant->classe->id;
        $this->editing = false;
        $this->deleting = false;
    }

    public function render()
    {
        return view('livewire.admin-dashboard.etudiant-profile', [
            'etudiant' => $this->etudiant,
            'classes' => $this->classes,
            'exams' => $this->exams,
        ]);
    }

    public function editStudent()
    {
        // dd($this->name);

        $this->validate([
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:1024',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->etudiant->user->id,
            'CNE' => 'required|string|max:20',
            'classe' => 'required|integer|exists:classes,id',
            // 'password' => 'nullable|string|min:8|max:255',
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
            'CNE.required' => 'Le CNE est obligatoire.',
            'CNE.max' => 'Le CNE ne doit pas dépasser 20 caractères.',
            'classe.required' => 'Vous devez sélectionner une classe.',
            'classe.integer' => 'La valeur sélectionnée doit être un nombre entier.',
            'classe.exists' => 'La classe sélectionnée n\'existe pas.',
            // 'password.required' => 'Le mot de passe est obligatoire.',
            // 'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            // 'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            // 'password.max' => 'Le mot de passe ne doit pas dépasser 255 caractères.',
            'phone.string' => 'Le champ téléphone doit être une chaîne de caractères.',
            'phone.min' => 'Le champ téléphone doit contenir au moins 10 caractères.',
            'phone.max' => 'Le champ téléphone ne doit pas dépasser 255 caractères.',
        ]);

        try {
            $this->etudiant->user->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                // 'password' => Hash::make($this->password),
            ]);

            if ($this->photo) {
                $this->etudiant->user->updateProfilePhoto($this->photo, $this->etudiant->user->id);
            }

            $this->etudiant->update([
                'CNE' => $this->CNE,
                'classe_id' => $this->classe,
            ]);
            $this->mount($this->etudiant->user->id);
            Toaster::success('Etudiant a bien été modifié');
        } catch (\Throwable $th) {
            throw $th;
            Toaster::error('Une erreur est servenu');
        }
    }

    public function cancelEditing()
    {
        $this->resetErrorBag();
        $this->mount($this->etudiant->user->id);
    }

    public function deleteProfilePhoto()
    {
        $this->etudiant->user->deleteProfilePhoto($this->etudiant->user);
    }

    public function deleteStudent()
    {
        $user = Auth::user();
        $this->validateOnly('adminPassword');
        try {
            if (password_verify($this->adminPassword, $user->password)) {
                $this->deleteProfilePhoto();

                $student = $this->etudiant;
                $user = $student->user;

                // Delete the student and associated user within a transaction
                DB::transaction(function () use ($student, $user) {
                    $student->delete();
                    $user->delete();
                });
                $this->reset('deleting');
                Redirect::route('etudiants')
                    ->success('Etudiant a bien été supprimeé.');
            } else {
                $this->addError('adminPassword', 'Le mot de passe est incorrect.');
            }

        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
    }

    public function resetPassword()
    {
        $this->validate([
            'email' => 'required|email|max:255|unique:users,email,' . $this->etudiant->user->id,
        ], [
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.max' => 'L\'email ne doit pas dépasser 255 caractères.',
            'email.unique' => 'Cet email est déjà utilisé.',
        ]);

        try {
            $password = Str::password(8);
            $this->etudiant->user->email = $this->email;
            $this->etudiant->user->password = Hash::make($password);
            $this->etudiant->user->save();
            Toaster::success('Mot de passe réinitialisé avec succée.');
            $this->sendPasswordEmail($this->etudiant->user->email, $password);
        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            // throw $th;
        }
    }

    public function sendPasswordEmail($email, $password)
    {
        try {
            SendPasswordEmail::dispatch($email, $password);
            Toaster::info('Le nouveau mot de passe a été envoyé à l\'étudiant par email.');
        } catch (\Exception $e) {
            Toaster::error('Une erreur est servenu au niveau d\'envoie d\'email');
        }
    }
}
