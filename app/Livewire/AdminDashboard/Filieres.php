<?php

namespace App\Livewire\AdminDashboard;

use Throwable;
use App\Models\Major;
use Livewire\Component;
use App\Models\Department;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Validate;

class Filieres extends Component
{

    public $addingFil = false;

    public $editingFiliereId;

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
            $this->resetPage();
        }


        return view('livewire.admin-dashboard.filieres', [
            'filieres' => $filieres->paginate(5),
            'departements' => Department::all(),
            // 'filieres' => Major::all(),
        ]);
    }

    public function addMajor() {
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

    public function edit($filiereId){
        $this->editingFiliereId = $filiereId;
        $this->editingFiliereName = Major::find($filiereId)->name;
        $this->editingFiliereDep = Major::find($filiereId)->department_id;
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

    public function delete($filiereId) {
       try {
           Major::find($filiereId)->delete();
        } catch (Throwable $th) {
            session()->flash('danger','Une erreur est servenu');
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
        Toaster::success('Filière a bien été supprimer');
    }

    public function cancelEdit() {
        $this->reset('editingFiliereId', 'editingFiliereName');
    }
}
