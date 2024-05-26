<?php

namespace App\Livewire\AdminDashboard;

use Throwable;
use App\Models\Major;
use Livewire\Component;
use App\Models\Department;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class Filieres extends Component
{

    public $addingFil = false;
    public $deletingFil = false;

    public $addingModule = false;

    public $editingFiliereId;
    public $deletingFiliereId;

    #[Validate('required', message: "Veuillez saisir votre mot de passe")]
    public $adminPassword;

    #[Validate('required', message: 'Veuillez entrer un nom pour la filière')]
    #[Validate('min:3', message: 'Le nom doit avoir au moins 3 caractères')]
    #[Validate('max:50', message: 'Le nom doit avoir au plus 50 caractères')]
    public $newFiliereName;

    #[Validate('required', message: 'Veuillez entrer un nom pour la filière')]
    #[Validate('min:3', message: 'Le nom doit avoir au moins 3 caractères')]
    #[Validate('max:50', message: 'Le nom doit avoir au plus 50 caractères')]
    public $editingFiliereName;

    #[Validate('required', message: 'Veuillez choisir une département auquelle appartient la filière')]
    public $newFiliereDep;

    public $editingFiliereDep;

    #[Validate('required', message: 'Veuillez entrer un nom pour le module')]
    #[Validate('min:3', message: 'Le nom doit avoir au moins 3 caractères')]
    #[Validate('max:50', message: 'Le nom doit avoir au plus 50 caractères')]
    public $moduleName;

    public $search = '';
    public $filter_dep = '';

    public function render()
    {

        $filieres = Major::withCount('classes');

        // Apply the department filter if selected
        if (!empty($this->filter_dep)) {
            $department = Department::find($this->filter_dep);
            if ($department) {
                $filieres->where('department_id', $department->id);
            }
        }

        // Apply the search filter
        if (!empty($this->search)) {
            $filieres->where('name', 'like', "%{$this->search}%");
        }


        return view('livewire.admin-dashboard.filieres', [
            'filieres' => $filieres->get(),
            'departements' => Department::all(),
            // 'filieres' => Major::all(),
        ]);
    }

    public function addMajor()
    {
        $this->validateOnly('newFiliereName');
        $this->validateOnly('newFiliereDep');
        try {
            Major::create([
                'name' => $this->newFiliereName,
                'department_id' => $this->newFiliereDep,
            ]);
        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
        $this->reset('newFiliereName');
        $this->reset('newFiliereDep');
        $this->reset('addingFil');
        Toaster::success('Filière a bien été ajoutée');
    }

    public function update() {
        $this->validateOnly('editingFiliereName');
        try {
            Major::find($this->editingFiliereId)->update([
                'name'=> $this->editingFiliereName,
                'department_id'=> $this->editingFiliereDep
            ]);
        } catch (Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
        $this->cancelEdit();
        Toaster::success('Filière a bien été modifiée');
    }

    public function delete() {
        $user = Auth::user();
        $this->validateOnly('adminPassword');
        try {
            if (password_verify($this->adminPassword, $user->password)) {
                Major::find($this->deletingFiliereId)->delete();
                $this->cancelDeleting();
                Toaster::success('Filière a bien été supprimer');
            } else {
                $this->addError('adminPassword', 'Le mot de passe est incorrect.');
            }
        } catch (Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
    }

    public function cancelDeleting()
    {
        $this->reset('deletingFil', 'deletingFiliereId');
    }

    public function cancelEdit() {
        $this->reset('editingFiliereId', 'editingFiliereName');
    }

    public function addModule() {
        $this->validateOnly('moduleName');
        try {
            Major::find($this->editingFiliereId)->modules()->create([
                'name' => $this->moduleName,
            ]);
            $this->reset('moduleName');
            $this->reset('addingModule');
            $this->reset('editingFiliereId');
            Toaster::success('Module a bien été ajouté');
        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }

    }
}
