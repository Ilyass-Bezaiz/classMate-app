<?php

namespace App\Livewire\AdminDashboard;

use App\Enums\Role;
use App\Models\User;
use App\Models\Classe;
use App\Models\Module;
use App\Models\Teacher;
use Livewire\Component;
use App\Mail\PasswordEmail;
use Illuminate\Support\Str;
use App\Models\Administrator;
use Masmerise\Toaster\Toaster;
use App\Jobs\SendPasswordEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Support\Facades\Redirect;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class AddTeacher extends Component
{
    use WithFileUploads;
    use HasProfilePhoto;
    public $photo = '';
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

    public function addTeacher()
    {
        $user;
        $password = Str::password(8);

        $this->validate([
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:1024',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,',
            'CIN' => 'required|string|min:8|max:8',
            // 'password' => 'required|string|min:8|max:255',
            // 'phone' => 'nullable|string|max:255|min:10',
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
            'CIN.max' => 'Le CIN doit avoir 8 caractères.',
            'CIN.min' => 'Le CIN doit avoir 8 caractères.',
            // 'password.required' => 'Le mot de passe est obligatoire.',
            // 'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            // 'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            // 'password.max' => 'Le mot de passe ne doit pas dépasser 255 caractères.',
            'diploma.required' => 'Le diplome est obligatoire.',
            'diploma.max' => 'Le diplome ne doit pas dépasser 255 caractères.',
            // 'phone.string' => 'Le champ téléphone doit être une chaîne de caractères.',
            // 'phone.min' => 'Le champ téléphone doit contenir au moins 10 caractères.',
            // 'phone.max' => 'Le champ téléphone ne doit pas dépasser 255 caractères.',
        ]);

        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($password),
                'role' => Role::TEACHER,
                // 'phone' => $this->phone,
            ]);

            if ($this->photo) {
                $user->updateProfilePhoto($this->photo, $user->id);
            }

            $teacher = Teacher::create([
                'user_id' => $user->id,
                'CIN' => $this->CIN,
                'module_id' => Module::inRandomOrder()->first()->id,
                'diploma' => $this->diploma,
            ]);
            $this->reset();
            Redirect::route('professeurs')
                ->success('Professeur a bien été ajouté');
            $this->sendPasswordEmail($user->email, $password);
        } catch (\Throwable $th) {
            // throw $th;
            Toaster::error('Une erreur est servenue.');
        }


    }

    public function sendPasswordEmail($email, $password)
    {
        try {
            SendPasswordEmail::dispatch($email, $password);
            Toaster::info('Le nouveau mot de passe a été envoyé au professeur par email.');
        } catch (\Exception $e) {
            Toaster::error('Une erreur est servenu au niveau d\'envoie d\'email');
        }
    }
}
