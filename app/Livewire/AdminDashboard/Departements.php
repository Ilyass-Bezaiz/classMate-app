<?php

namespace App\Livewire\AdminDashboard;

use Livewire\Component;
use App\Models\Department;
use Livewire\Attributes\Validate;
use App\Livewire\ToastMessage;


class Departements extends Component
{

    public $editingDepId;
    public $addingDep =false;

    #[Validate('required', message: 'Veuillez entrer un nom pour la département')]
    #[Validate('min:3', message: 'Le nom doit avoir au moins 3 caractères')]
    #[Validate('max:50', message: 'Le nom doit avoir au plus 50 caractères')]
    public $editingDepName;

    #[Validate('required', message: 'Veuillez entrer un nom pour la département')]
    #[Validate('min:3', message: 'Le nom doit avoir au moins 3 caractères')]
    #[Validate('max:50', message: 'Le nom doit avoir au plus 50 caractères')]
    public $newDepName;

    public $search = '';

    public function render()
    {
        $departements = Department::withCount('majors');

        // Apply the search filter
        if (!empty($this->search)) {
            $departements->where('name', 'like', "%{$this->search}%");
        }

        return view('livewire.admin-dashboard.departements',[
            'departements' => $departements->paginate(5),
        ]);
    }

    public function addingDepartement() {
        return true;
    }

    public function add() {
        $validated = $this->validateOnly('newDepName');
        try {
            Department::create([
                'name' => $this->newDepName,
            ]);
        } catch (\Throwable $th) {
            session()->flash('danger','Une erreur est servenu');
            throw $th;
        }
        $this->reset('newDepName');
        $this->reset('addingDep');
        session()->flash('success','Département a bien été ajoutée');
    }

    public function edit($depId){
        $this->editingDepId = $depId;
        $this->editingDepName = Department::find($depId)->name;
    }

    public function update() {
        $this->validateOnly('editingDepName');
        try {
            Department::find($this->editingDepId)->update([
                'name'=> $this->editingDepName,
            ]);
        } catch (\Throwable $th) {
            session()->flash('danger','Une erreur est servenu');
            throw $th;
        }
        $this->cancelEdit();
        session()->flash('success','Département a bien été modifiée');
    }

    public function delete($depId) {
        try {
            Department::find($depId)->delete();
        } catch (\Throwable $th) {
            session()->flash('danger','Une erreur est servenu');
            throw $th;
        }
        session()->flash('success','Département a bien été supprimeée');
    }

    public function cancelEdit() {
        $this->reset('editingDepId', 'editingDepName');
    }
}
