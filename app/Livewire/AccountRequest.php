<?php

namespace App\Livewire;

use App\Enums\Role;
use App\Models\Classe;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use App\Jobs\SendRequestAccountEmail;
use Illuminate\Support\Facades\Redirect;

class AccountRequest extends Component
{
    public $name = '';
    public $email = '';
    public $CIN = '';
    public $diploma = '';
    public $CNE = '';
    public $classe = '';
    public $role;

    public function mount()
    {
        $this->role = "Teacher";
    }

    public function render()
    {
        return view('livewire.account-request',[
            'classes' => Classe::all(),
        ])->layout('layouts.guest');
    }

    public function sendTeacherRequest()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,',
            'CIN' => 'required|string|min:8|max:8',
            'diploma' => 'required|string|max:255',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.max' => 'L\'email ne doit pas dépasser 255 caractères.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'CIN.required' => 'Le CIN est obligatoire.',
            'CIN.max' => 'Le CIN doit avoir 8 caractères.',
            'CIN.min' => 'Le CIN doit avoir 8 caractères.',
            'diploma.required' => 'Le diplome est obligatoire.',
            'diploma.max' => 'Le diplome ne doit pas dépasser 255 caractères.',
        ]);
        $details=[];
        try {
            $details = [
                'name' => $this->name,
                'email' => $this->email,
                'CIN' => $this->CIN,
                'diploma' => $this->diploma,
                'role' => Role::TEACHER,
            ];
            $this->sending($details);
            Redirect::route('welcome')->success('Un email a été envoyé avec vos informations à l\'administrateur.');
        } catch (\Throwable $th) {
            throw $th;
            Toaster::error('Une erreur est servenue.');
        }
    }

    public function sendStudentRequest()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,',
            'CNE' => 'required|string|min:10|max:10',
            'classe' => 'required|integer|exists:classes,id',
        ], [
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
        ]);
        $details=[];
        try {
            $details = [
                'name' => $this->name,
                'email' => $this->email,
                'CNE' => $this->CNE,
                'classe' => $this->classe,
                'role' => Role::STUDENT,
            ];
            $this->sending($details);
            Redirect::route('welcome')->success('Un email a été envoyé avec vos informations à l\'administrateur.');
        } catch (\Throwable $th) {
            throw $th;
            Toaster::error('Une erreur est servenue.');
        }
    }

    public function sending($details)
    {
        try {
            SendRequestAccountEmail::dispatch($details);
        } catch (\Exception $e) {
            Toaster::error('Une erreur est servenu au niveau d\'envoie d\'email');
        }
    }
}
