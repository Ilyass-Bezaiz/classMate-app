<?php

namespace App\Livewire;

use App\Enums\Role;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;
use App\Jobs\SendRequestAccountEmail;
use Illuminate\Support\Facades\Redirect;

class TeacherAccountRequest extends Component
{
    public $name = '';
    public $email = '';
    public $CIN = '';
    public $diploma = '';

    public function render()
    {
        return view('livewire.teacher-account-request')->layout('layouts.guest');
    }

    public function send()
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
            Redirect::route('welcome')->success('Un email a été envoyé avec succès à l\'administrateur.');
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
