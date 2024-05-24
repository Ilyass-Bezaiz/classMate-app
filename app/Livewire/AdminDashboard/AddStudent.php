<?php

namespace App\Livewire\AdminDashboard;

use App\Enums\Role;
use App\Models\User;
use App\Models\Classe;
use App\Models\Student;
use Livewire\Component;
use App\Models\Administrator;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\HasProfilePhoto;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class AddStudent extends Component
{
    use WithFileUploads;
    use HasProfilePhoto;


    public $photo;
    public $name = '';
    public $CNE = '';
    public $email = '';
    public $phone = '';
    public $classe = '';
    public $password = '';
    public function render()
    {
        return view(
            'livewire.admin-dashboard.add-student',
            [
                'classes' => Classe::all(),
            ]
        );
    }

    public function save()
    {
        // dd($this->classe);
        $this->validate([
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:1024',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,',
            'CNE' => 'required|string|max:20',
            'classe' => 'required|integer|exists:classes,id',
            'password' => 'required|string|min:8|max:255',
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

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => Role::STUDENT,
            'phone' => $this->phone,
        ]);

        $admin = Administrator::where('user_id', Auth::User()->id)->first();
        // dd($admin);
        if ($this->photo) {
            Auth::User()->role == Role::ADMIN ?  Administrator::where('user_id', Auth::User()->id)->first() : null;
            $admin->updateProfilePhoto($this->photo, $user->id);
        }

        Student::create([
            'user_id' => $user->id,
            'CNE' => $this->CNE,
            'classe_id' => $this->classe,
        ]);

        Toaster::success('Etudiant a bien été ajouté');
        $this->reset();
        // dd($user, $student);
    }
}
