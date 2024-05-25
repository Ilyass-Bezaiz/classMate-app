<?php

namespace App\Livewire\AdminDashboard;

use App\Enums\Role;
use App\Models\User;
use App\Models\Classe;
use App\Models\Module;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\Administrator;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\HasProfilePhoto;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class AddTeacher extends Component
{
    use WithFileUploads;
    use HasProfilePhoto;
    public $photo;
    public $name = '';
    public $CIN = '';
    public $email = '';
    public $password = '';
    public $phone = '';
    public $diploma = '';

    public function render()
    {
        return view(
            'livewire.admin-dashboard.add-teacher',
            [
                'classes' => Classe::all(),
                'modules' => Module::all()
            ]
        );
    }

    public function save()
    {
        // dd($this->diploma);
        $this->validate([
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:1024',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,',
            'CIN' => 'required|string|max:12',
            'password' => 'required|string|min:8|max:255',
            'phone' => 'nullable|string|max:255|min:10',
            'diploma' => 'required|string|max:255',
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
            'CIN.max' => 'Le CIN ne doit pas dépasser 20 caractères.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.max' => 'Le mot de passe ne doit pas dépasser 255 caractères.',
            'diploma.required' => 'Le diplome est obligatoire.',
            'diploma.max' => 'Le diplome ne doit pas dépasser 255 caractères.',
            'phone.string' => 'Le champ téléphone doit être une chaîne de caractères.',
            'phone.min' => 'Le champ téléphone doit contenir au moins 10 caractères.',
            'phone.max' => 'Le champ téléphone ne doit pas dépasser 255 caractères.',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => Role::TEACHER,
            'phone' => $this->phone,
        ]);

        $admin = Administrator::where('user_id', Auth::User()->id)->first();
        // dd($admin);
        if ($this->photo) {
            Auth::User()->role == Role::ADMIN ?  Administrator::where('user_id', Auth::User()->id)->first() : null;
            $admin->updateProfilePhoto($this->photo, $user->id);
        }

        $teacher = Teacher::create([
            'user_id' => $user->id,
            'CIN' => $this->CIN,
            'module_id' => Module::inRandomOrder()->first()->id,
            'diploma' => $this->diploma,
        ]);
        Toaster::success('Professeur a bien été ajouté');
        $this->reset();
    }
}
