<?php

namespace App\Livewire\AdminDashboard;

use App\Enums\Role;
use App\Models\User;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\Administrator;
use Livewire\WithFileUploads;
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
    public $adminPassword;
    public $confirmingUserDeletion = false;
    // public $password = '';

    public function mount($id)
    {
        $this->user = User::find($id);
        // dd($this->user);
        $this->teacher = Teacher::where('user_id', $id)->first();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->CIN = $this->teacher->CIN;
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
            'CIN' => 'required|string|max:12',
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
            // 'phone' => $this->phone,
            // 'password' => $this->password,
        ]);
        $this->teacher->update([
            'CIN' => $this->CIN,
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
        $teacher = $this->teacher;
        $user = $teacher->user;

        // Delete the teacher and associated user within a transaction
        DB::transaction(function () use ($teacher, $user) {
            $teacher->delete();
            $user->delete();
        });

        // Flash message to the session
        session()->flash('message', 'Teacher and associated user deleted successfully.');

        // Redirect to the teachers route
        return redirect()->route('professeurs');
    }

    public function render()
    {
        return view('livewire.admin-dashboard.edit-teacher');
    }
}
