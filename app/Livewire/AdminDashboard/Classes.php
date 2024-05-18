<?php

namespace App\Livewire\AdminDashboard;

use App\Models\Classe;
use App\Models\Major;
use Livewire\Component;
use App\Models\Department;
use Livewire\WithPagination;

class Classes extends Component
{
    use WithPagination;

    public $search = '';
    public $filter_dep = '';
    public $filter_fil = '';


    public function render()
    {

        // Start with the base query
        // $classes = Classe::query();
        $classes = Classe::withCount('students');


        // Apply the major filter if selected
        if (!empty($this->filter_fil)) {
            $classes->where('major_id', $this->filter_fil);
        }

        // Apply the department filter if selected
        if (!empty($this->filter_dep)) {
            $department = Department::find($this->filter_dep);
            if ($department) {
                $majorIds = $department->majors->pluck('id');
                $classes->whereIn('major_id', $majorIds);
            }
        }

        // Apply the search filter
        if (!empty($this->search)) {
            $classes->where('name', 'like', "%{$this->search}%");
        }

        // Paginate the results
        $classes = $classes->latest()->paginate(10);
        // dd($classes[5]->students_count);
        return view('livewire.admin-dashboard.classes', [
            'classes' => $classes,
            'departements' => Department::all(),
            'filieres' => Major::all(),
        ]);
    }
}
