<?php

namespace App\Livewire\AdminDashboard;

use App\Enums\Role;
use App\Models\User;
use App\Models\Classe;
use App\Models\Student;
use Livewire\Component;
use App\Models\Administrator;
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
        $this->validate([
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:1024',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,',
            'CNE' => 'required|string|max:20',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => Role::STUDENT,
            // 'phone' => $this->phone,
        ]);

        $admin = Administrator::where('user_id', Auth::User()->id)->first();
        // dd($admin);
        if ($this->photo) {
            Auth::User()->role == Role::ADMIN ?  Administrator::where('user_id', Auth::User()->id)->first() : null;
            $admin->updateProfilePhoto($this->photo, $user->id);
        }

        $student = Student::create([
            'user_id' => $user->id,
            'CNE' => $this->CNE,
            'classe_id' => Classe::all()->random()->first()->id,
        ]);
        // dd($user, $student);
    }
}
