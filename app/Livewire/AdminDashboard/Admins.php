<?php

namespace App\Livewire\AdminDashboard;

use App\Models\User;
use Livewire\Component;
use App\Mail\PasswordEmail;
use Illuminate\Support\Str;
use App\Models\Administrator;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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

    #[Validate('required', message: "Veuillez saisir votre mot de passe")]
    public $adminPassword;

    public $search = '';

    public function resetPassword() {
        $admin = Administrator::find($this->resetingAdminId);
        try {
            $password = Str::password(8);
            $admin->user->password =  Hash::make($password);
            $admin->user->save();
            Mail::to($admin->user->email)->send(new PasswordEmail($password));
            $this->reset('resetingAdminId');
            Toaster::info('Mot de passe réinitialisé et envoyé au utilisateur par email');
        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            // throw $th;
        }
    }

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

    public function addAdmin()
    {
        $this->validateOnly('newAdminName');
        $this->validateOnly('newAdminCIN');
        $this->validateOnly('newAdminEmail');
        try {
            $user = User::create([
                'name' => $this->newAdminName,
                'email' => $this->newAdminEmail,
                'role' => 'Administrator',
                'password' => Hash::make("12345678"),
            ]);

            Administrator::create([
                'user_id' => $user->id,
                'access_code' => "1323",
                'CIN' => $this->newAdminCIN,
            ]);

            $this->reset('addingAdmin');
            Toaster::success('Admin a bien été ajouté');
            // Toaster::info('un email avec mot de passe a été envoyé au utilisateur');

            $this->reset('newAdminName');
            $this->reset('newAdminCIN');
            $this->reset('newAdminEmail');
        } catch (\Throwable $th) {
            $this->reset('addingAdmin');
            $this->reset('newAdminName');
            $this->reset('newAdminCIN');
            $this->reset('newAdminEmail');
            Toaster::error('Une erreur est servenu');
            throw $th;
        }

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
