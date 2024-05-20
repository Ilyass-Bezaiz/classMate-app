<?php

namespace App\Livewire\AdminDashboard;

use App\Models\Major;
use Livewire\Component;
use App\Models\Department;
use Livewire\Attributes\Rule;

class Filieres extends Component
{

    public $addingFil = false;

    public $editingFiliereId;

    #[Rule('required|min:3|max:50')]
    public $newFiliereName;

    #[Rule('required|min:3|max:50')]
    public $editingFiliereName;

    #[Rule('required')]
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
        Major::create([
            'name' => $this->newFiliereName,
            'department_id' => $this->newFiliereDep,
        ]);
        $this->reset('newFiliereName');
        $this->reset('newFiliereDep');
        $this->reset('addingFil');
        session()->flash('success','Created Successfully');
    }

    public function edit($filiereId){
        $this->editingFiliereId = $filiereId;
        $this->editingFiliereName = Major::find($filiereId)->name;
        $this->editingFiliereDep = Major::find($filiereId)->department_id;
    }

    public function update() {
        $this->validateOnly('editingFiliereName');
        Major::find($this->editingFiliereId)->update([
            'name'=> $this->editingFiliereName,
            'department_id'=> $this->editingFiliereDep
        ]);
        $this->cancelEdit();
        session()->flash('filiereUpdated', "Filière updated successfely");
    }

    public function delete($filiereId) {
        Major::find($filiereId)->delete();
    }

    public function cancelEdit() {
        $this->reset('editingFiliereId', 'editingFiliereName');
    }
}
