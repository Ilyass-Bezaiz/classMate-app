<?php

namespace App\Livewire\AdminDashboard;

use Livewire\Component;
use App\Imports\UsersImport;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;
use App\Imports\StudentsImport;
use App\Imports\TeachersImport;
use Maatwebsite\Excel\Facades\Excel;

class UploadData extends Component
{
    use WithFileUploads;

    public $professeursFile;
    public $etudiantsFile;
    public function render()
    {
        return view('livewire.admin-dashboard.upload-data');
    }

    public function importProfesseurs()
    {
        try {
            Excel::import(new UsersImport, $this->professeursFile);
            Excel::import(new TeachersImport, $this->professeursFile);
            Toaster::success('Professeurs a bien été ajouté');
        } catch (\Throwable $th) {
            // Toaster::error($th->getMessage());
            throw $th;
        }
    }

    public function importEtudiants()
    {
        try {
            Excel::import(new UsersImport, $this->etudiantsFile);
            Excel::import(new StudentsImport, $this->etudiantsFile);
            Toaster::success('Etudiants a bien été ajouté');
        } catch (\Throwable $th) {
            // Toaster::error($th->getMessage());
            throw $th;
        }
    }
}
