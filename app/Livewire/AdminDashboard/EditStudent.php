<?php

namespace App\Livewire\AdminDashboard;

use App\Enums\Role;
use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use App\Models\Administrator;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
        $this->phone = $this->user->phone;
        // $this->photo = $this->user->profile_photo_url;
    }

    public function save()
    {
        $this->validate([
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:1024',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'CNE' => 'required|string|max:22',
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
            // 'phone' => $this->phone,
            // 'password' => $this->password,
        ]);
        $this->student->update([
            'CNE' => $this->CNE,
            // 'diplome' => $this->diplome,
        ]);

        session()->flash('ProfesseurUpdated', " Professeur updated successfely");
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

        // Flash message to the session
        session()->flash('message', 'Student and associated user deleted successfully.');

        // Redirect to the etudiants route
        return redirect()->route('etudiants');
    }


    public function render()
    {
        return view(
            'livewire.admin-dashboard.edit-student'
        );
    }
}
