<?php

namespace App\Livewire\AdminDashboard;

use App\Enums\Role;
use App\Models\User;
use App\Models\Classe;
use App\Models\Student;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Administrator;
use Masmerise\Toaster\Toaster;
use App\Jobs\SendPasswordEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Support\Facades\Redirect;
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

    public function addStudent()
    {
        $this->validate([
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:1024',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,',
            'CNE' => 'required|string|min:10|max:10',
            'classe' => 'required|integer|exists:classes,id',
            // 'phone' => 'nullable|string|max:255|min:10',
            // 'password' => 'required|string|min:8|max:255',
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
            'CNE.max' => 'Le CNE doit avoir 10 caractères.',
            'CNE.min' => 'Le CNE doit avoir 10 caractères.',
            'classe.required' => 'Vous devez sélectionner une classe.',
            'classe.integer' => 'La valeur sélectionnée doit être un nombre entier.',
            'classe.exists' => 'La classe sélectionnée n\'existe pas.',
            // 'password.required' => 'Le mot de passe est obligatoire.',
            // 'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            // 'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            // 'password.max' => 'Le mot de passe ne doit pas dépasser 255 caractères.',
            // 'phone.string' => 'Le champ téléphone doit être une chaîne de caractères.',
            // 'phone.min' => 'Le champ téléphone doit contenir au moins 10 caractères.',
            // 'phone.max' => 'Le champ téléphone ne doit pas dépasser 255 caractères.',
        ]);

       try {
            $password = Str::password(8);
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($password),
                'role' => Role::STUDENT,
                'phone' => $this->phone,
            ]);

            if ($this->photo) {
                $user->updateProfilePhoto($this->photo, $user->id);
            }

            Student::create([
                'user_id' => $user->id,
                'CNE' => $this->CNE,
                'classe_id' => $this->classe,
            ]);

            $this->reset();
            Redirect::route('etudiants')
                ->success('Etudiant a bien été ajouté');
            $this->sendPasswordEmail($user->email, $password);
        }
        catch (\Throwable $th) {
            //throw $th;
            Toaster::error('Une erreur est servenue.');
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
