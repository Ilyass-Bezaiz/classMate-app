<?php

namespace App\Livewire\AdminDashboard;

use App\Enums\Role;
use App\Models\User;
use App\Models\Classe;
use App\Models\Student;
use Livewire\Component;
use App\Models\Administrator;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class EditStudent extends Component
{
    use WithFileUploads;
    public $student = '';
    public $user;
    public $photo;
    public $name = '';
    public $CNE = '';
    public $email = '';
    public $classe = '';
    public $password = '';
    public $adminPassword;
    public $phone = '';
    public $confirmingUserDeletion = false;
    public function mount($id)
    {
        $this->user = User::find($id);
        $this->student = Student::where('user_id', $id)->first();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->CNE = $this->student->CNE;
        // $this->password = $this->student->user->password;
        // $this->photo = $this->user->profile_photo_url;
        $this->phone = $this->user->phone;
        $this->classe = $this->student->classe_id;
    }

    public function save()
    {
        $this->validate([
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:1024',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'CNE' => 'required|string|max:20',
            'classe' => 'required|integer|exists:classes,id',
            'password' => 'nullable|string|min:8|max:255',
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
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.max' => 'Le mot de passe ne doit pas dépasser 255 caractères.',
        ]);

        $admin = Administrator::where('user_id', Auth::User()->id)->first();
        // dd($admin);
        if ($this->photo) {
            Auth::User()->role == Role::ADMIN ?  Administrator::where('user_id', Auth::User()->id)->first() : null;
            $admin->updateProfilePhoto($this->photo, $this->student->user->id);
        }
        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
        ]);
        $this->student->update([
            'CNE' => $this->CNE,
            'classe_id' => $this->classe,
        ]);

        session()->flash('message');
        Toaster::success('Etudiant a bien été modifié');
    }

    public function deleteProfilePhoto()
    {
        $admin = Auth::User()->role == Role::ADMIN ?  Administrator::where('user_id', Auth::User()->id)->first() : null;
        $admin->deleteProfilePhoto($this->user);
    }

    public function confirmUserDeletion()
    {
        $this->resetErrorBag();

        $this->adminPassword = '';

        $this->dispatch('confirming-delete-user');

        $this->confirmingUserDeletion = true;
    }

    public function deleteUser()
    {
        if (!Hash::check($this->adminPassword, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'adminPassword' => [__('This password does not match our records.')],
            ]);
        }
        $this->deleteProfilePhoto();

        $student = $this->student;
        $user = $student->user;

        // Delete the student and associated user within a transaction
        DB::transaction(function () use ($student, $user) {
            $student->delete();
            $user->delete();
        });

        // Redirect to the etudiants route
        return redirect()->route('etudiants')->success("Etudiant a bien été supprimé");
    }


    public function render()
    {
        return view(
            'livewire.admin-dashboard.edit-student',
            [
                'classes' => Classe::all(),
            ]
        );
    }
}
