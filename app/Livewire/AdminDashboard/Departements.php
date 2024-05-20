<?php

namespace App\Livewire\AdminDashboard;

use Livewire\Component;
use App\Models\Department;
use Livewire\Attributes\Rule;


class Departements extends Component
{

    public $editingDepId;
    public $addingDep =false;

    #[Rule('required|min:3|max:50')]
    public $editingDepName;

    #[Rule('required|min:3|max:50')]
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
        Department::create([
            'name' => $this->newDepName,
        ]);
        $this->reset('newDepName');
        $this->reset('addingDep');
        session()->flash('success','Created Successfully');
    }

    public function edit($depId){
        $this->editingDepId = $depId;
        $this->editingDepName = Department::find($depId)->name;
    }

    public function update() {
        $this->validateOnly('editingDepName');
        Department::find($this->editingDepId)->update([
            'name'=> $this->editingDepName,
        ]);
        $this->cancelEdit();
        session()->flash('departmentUpdated', "Department updated successfely");
    }

    public function delete($depId) {
        Department::find($depId)->delete();
    }

    public function cancelEdit() {
        $this->reset('editingDepId', 'editingDepName');
    }
}
