<?php

namespace App\Livewire\AdminDashboard;

use App\Enums\Role;
use App\Models\User;
use App\Models\Classe;
use App\Models\Teacher;
use Laravel\Jetstream\HasProfilePhoto;
use Livewire\Component;
use App\Models\Administrator;
use App\Models\Major;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function render()
    {
        return view(
            'livewire.admin-dashboard.add-teacher',
            [
                'classes' => Classe::all(),
            ]
        );
    }

    public function save()
    {
        $this->validate([
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:1024',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,',
            'CIN' => 'required|string|max:12',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => Role::TEACHER,
            // 'phone' => $this->phone,
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
            'module_id' => Module::all()->random()->first()->id,
        ]);
        dd($user, $teacher);
    }
}
