<?php

namespace App\Livewire\AdminDashboard;

use App\Enums\Role;
use App\Models\User;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\Administrator;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EditTeacher extends Component
{
    use WithFileUploads;
    use HasProfilePhoto;

    public $teacher = '';
    public $user;
    public $photo;
    public $name = '';
    public $CIN = '';
    public $email = '';
    public $password = '';
    public $phone = '';
    public $diploma = '';
    public $adminPassword;
    public $confirmingUserDeletion = false;

    public function mount($id)
    {
        $this->user = User::find($id);
        // dd($this->user);
        $this->teacher = Teacher::where('user_id', $id)->first();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->CIN = $this->teacher->CIN;
        $this->phone = $this->user->phone;
        $this->diploma = $this->teacher->diploma;
        // $this->password = $this->teacher->user->password;
    }

    public function save()
    {
        $this->validate([
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:1024',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'CIN' => 'required|string|max:12',
            'password' => 'nullable|string|min:8|max:255',
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
        ]);

        $admin = Administrator::where('user_id', Auth::User()->id)->first();
        // dd($admin);
        if ($this->photo) {
            Auth::User()->role == Role::ADMIN ?  Administrator::where('user_id', Auth::User()->id)->first() : null;
            $admin->updateProfilePhoto($this->photo, $this->teacher->user->id);
        }
        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
        ]);
        $this->teacher->update([
            'CIN' => $this->CIN,
            'diploma' => $this->diploma,
        ]);
        session()->flash('message');
        Toaster::success('Professeur a bien été modifié');
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
        $teacher = $this->teacher;
        $user = $teacher->user;

        // Delete the teacher and associated user within a transaction
        DB::transaction(function () use ($teacher, $user) {
            $teacher->delete();
            $user->delete();
        });

        // Redirect to the teachers route
        return redirect()->route('professeurs')->success("Professeur a bien été supprimé");
    }

    public function render()
    {
        return view('livewire.admin-dashboard.edit-teacher');
    }
}
