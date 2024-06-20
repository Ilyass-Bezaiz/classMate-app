<?php

namespace App\Livewire\AdminDashboard;

use App\Enums\Role;
use App\Models\User;
use Livewire\Component;
use App\Mail\PasswordEmail;
use Illuminate\Support\Str;
use App\Imports\UsersImport;
use App\Models\Administrator;
use Masmerise\Toaster\Toaster;
use App\Jobs\SendPasswordEmail;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class Admins extends Component
{
    public $addingAdmin = false;
    public $resetingAdmin = false;
    public $deletingAdmin = false;

    public $deletingAdminId;
    public $resetingAdminId;

    #[Validate('required', message: 'Veuillez entrer le nom de l\'admin')]
    #[Validate('min:6', message: 'Le nom doit avoir au moins 6 caractères')]
    #[Validate('max:25', message: 'Le nom doit avoir au plus 25 caractères')]
    public $newAdminName;

    #[Validate('required', message: 'Veuillez entrer le CIN')]
    #[Validate('unique:administrators,CIN', message: 'CIN deja utilisé')]
    #[Validate('min:6', message: 'Le CIN doit avoir au moins 6 caractères')]
    #[Validate('max:8', message: 'Le CIN doit avoir au plus 8 caractères')]
    public $newAdminCIN;

    #[Validate('required', message: 'Veuillez entrer l\'email')]
    #[Validate('email', message: 'Veuillez entrer un email valide')]
    #[Validate('unique:users,email', message: 'email déja utilisée')]
    public $newAdminEmail;

    #[Validate('required', message: 'Veuillez entrer un email')]
    #[Validate('email', message: 'Veuillez entrer un email valide')]
    public $resetAdminEmail;

    #[Validate('required', message: "Veuillez saisir votre mot de passe")]
    public $adminPassword;

    public $search = '';

    public function render()
    {
        $adminsQuery = Administrator::query();
        $adminUsers = User::where('role', 'Administrator')
                                        ->where('name', 'like', "%{$this->search}%")
                                        ->get();

        $adminsQuery->whereIn('user_id', $adminUsers->pluck('id'));

        return view('livewire.admin-dashboard.admins', [
            'admins' => $adminsQuery->get(),
        ]);
    }

    public function resetAdminAccount()
    {
        $admin = Administrator::find($this->resetingAdminId);
        try {
            $this->validateOnly('resetAdminEmail');
            $password = Str::password(8);
            $admin->user->email = $this->resetAdminEmail;
            $admin->user->password = Hash::make($password);
            $admin->user->save();
            $this->reset('resetingAdminId');
            $this->reset('resetAdminEmail');
            $this->sendPasswordEmail($admin->user->email, $password);
            Toaster::success('Compte réinitialisé avec succée');
        } catch (\Throwable $th) {
            $this->resetingAdmin = true;
            Toaster::error('Une erreur est servenu');
            // throw $th;
        }
    }

    public function sendPasswordEmail($email, $password)
    {
        try {
            SendPasswordEmail::dispatch($email, $password);
            Toaster::info('Le nouveau mot de passe a été envoyé à l\'admin par email.');
        } catch (\Exception $e) {
            Toaster::error('Une erreur est servenu au niveau d\'envoie d\'email');
        }
    }

    public function addAdmin()
    {
        $this->validateOnly('newAdminName');
        $this->validateOnly('newAdminCIN');
        $this->validateOnly('newAdminEmail');
        try {
            $password = Str::password(8);
            $user = User::create([
                'name' => $this->newAdminName,
                'email' => $this->newAdminEmail,
                'role' => Role::ADMIN,
                'password' => Hash::make($password),
            ]);

            Administrator::create([
                'user_id' => $user->id,
                'CIN' => $this->newAdminCIN,
            ]);

            $this->reset('addingAdmin');
            Toaster::success('Admin a bien été ajouté');
            $this->reset('newAdminName');
            $this->reset('newAdminCIN');
            $this->reset('newAdminEmail');
        } catch (\Throwable $th) {
            $this->reset('addingAdmin');
            $this->reset('newAdminName');
            $this->reset('newAdminCIN');
            $this->reset('newAdminEmail');
            Toaster::error('Une erreur est servenu');
            // throw $th;
        }
        $this->sendPasswordEmail($user->email, $password);
    }

    public function delete()
    {
        $user = Auth::user();
        $this->validateOnly('adminPassword');
        try {
            if (password_verify($this->adminPassword, $user->password)) {
                $delAdmin = Administrator::find($this->deletingAdminId);
                $delUser = $delAdmin->user;
                DB::transaction(function () use ($delAdmin, $delUser) {
                    $delAdmin->delete();
                    $delUser->delete();
                });
                $this->reset('deletingAdmin');
                $this->reset('deletingAdminId');
                $this->reset('adminPassword');
                Toaster::success('Admin a bien été supprimeé');
            } else {
                $this->addError('adminPassword', 'Le mot de passe est incorrect.');
            }

        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
    }
}
