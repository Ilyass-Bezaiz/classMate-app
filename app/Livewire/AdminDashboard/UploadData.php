<?php

namespace App\Livewire\AdminDashboard;

use App\Enums\Role;
use App\Models\User;
use Livewire\Component;
use App\Imports\UsersImport;
use Livewire\WithFileUploads;
use App\Imports\ModulesImport;
use Masmerise\Toaster\Toaster;
use App\Imports\FilieresImport;
use App\Imports\StudentsImport;
use App\Imports\TeachersImport;
use Livewire\Attributes\Validate;
use App\Imports\DepartementsImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;

class UploadData extends Component
{
    use WithFileUploads;

    public static $UserRole;
    public $confirmDataDeletion = false;

    #[Validate('required', message: "Veuillez saisir votre mot de passe")]
    public $superAdminPassword;

    #[Validate('required', message: 'Veuillez selectionner un fichier')]
    #[Validate('mimes:xlsx,xls', message: 'Le fichier doit être de type Excel ".xlsx"')]
    #[Validate('max:10240', message: 'Le fichier doit être moins de 10MB')]
    public $professeursFile;

    #[Validate('required', message: 'Veuillez selectionner un fichier')]
    #[Validate('mimes:xlsx,xls', message: 'Le fichier doit être de type Excel ".xlsx"')]
    #[Validate('max:10240', message: 'Le fichier doit être moins de 10MB')]
    public $etudiantsFile;

    #[Validate('required', message: 'Veuillez selectionner un fichier')]
    #[Validate('mimes:xlsx,xls', message: 'Le fichier doit être de type Excel ".xlsx"')]
    #[Validate('max:10240', message: 'Le fichier doit être moins de 10MB')]
    public $modulesFile;

    #[Validate('required', message: 'Veuillez selectionner un fichier')]
    #[Validate('mimes:xlsx,xls', message: 'Le fichier doit être de type Excel ".xlsx"')]
    #[Validate('max:10240', message: 'Le fichier doit être moins de 10MB')]
    public $filieresFile;

    #[Validate('required', message: 'Veuillez selectionner un fichier')]
    #[Validate('mimes:xlsx,xls', message: 'Le fichier doit être de type Excel ".xlsx"')]
    #[Validate('max:10240', message: 'Le fichier doit être moins de 10MB')]
    public $departementsFile;

    public function render()
    {
        return view('livewire.admin-dashboard.upload-data');
    }

    public function importProfesseurs()
    {
        $this->validateOnly('professeursFile');
        try {
            self::$UserRole = Role::TEACHER;
            Excel::import(new UsersImport, $this->professeursFile);
            Excel::import(new TeachersImport, $this->professeursFile);
            self::$UserRole = null;
            Toaster::success('Professeurs ont bien été ajoutés');
        } catch (\Throwable $th) {
            Toaster::error($th->getMessage());
            // throw $th;
        }
    }

    public function importEtudiants()
    {
        $this->validateOnly('etudiantsFile');
        try {
            self::$UserRole = Role::STUDENT;
            Excel::import(new UsersImport, $this->etudiantsFile);
            Excel::import(new StudentsImport, $this->etudiantsFile);
            self::$UserRole = null;
            Toaster::success('Etudiants ont bien été ajoutés');
        } catch (\Throwable $th) {
            Toaster::error($th->getMessage());
            // throw $th;
        }
    }

    public function importModules()
    {
        $this->validateOnly('modulesFile');
        try {
            Excel::import(new ModulesImport, $this->modulesFile);
            Toaster::success('Modules ont bien été ajoutés');
        } catch (\Throwable $th) {
            Toaster::error($th->getMessage());
            // throw $th;
        }
    }

    public function importFilieres()
    {
        $this->validateOnly('filieresFile');
        try {
            Excel::import(new FilieresImport, $this->filieresFile);
            Toaster::success('Filières ont bien été ajoutés');
        } catch (\Throwable $th) {
            Toaster::error($th->getMessage());
            // throw $th;
        }
    }

    public function importDepartements()
    {
        $this->validateOnly('departementsFile');
        try {
            Excel::import(new DepartementsImport, $this->departementsFile);
            Toaster::success('Départements ont bien été ajoutés');
        } catch (\Throwable $th) {
            Toaster::error($th->getMessage());
            // throw $th;
        }
    }

    public function deleteAllData()
    {
        $user = Auth::user();
        $this->validateOnly('superAdminPassword');
        try {
            if (password_verify($this->superAdminPassword, $user->password)) {
                // Run the migrate:fresh command
                Artisan::call('migrate:fresh');

                // Run the UserTableSeeder
                Artisan::call('db:seed', [
                    '--class' => 'UserSeeder'
                ]);
                $this->reset('confirmDataDeletion');
                Toaster::success('Les données ont bien été supprimeées.');
                Toaster::info('Vous aurez être diriger vers page de connexion...');
            } else {
                $this->addError('superAdminPassword', 'Le mot de passe est incorrect.');
            }
        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            //throw $th;
        }
    }
}
