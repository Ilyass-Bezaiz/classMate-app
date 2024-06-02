<?php

namespace App\Livewire\AdminDashboard;

use App\Models\User;
use App\Models\Major;
use App\Models\Classe;
use App\Models\Module;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\Department;

class Professeurs extends Component
{
    public $search;
    public $filter_dep;
    public $filter_fil;

    public function render()
    {
        $professeursQuery = Teacher::query();
        $teacherUsers = User::where('role', 'Teacher')
                                        ->where('name', 'like', "%{$this->search}%")
                                        ->get();
        $professeursQuery->whereIn('user_id', $teacherUsers->pluck('id'));

        // Apply department filter
        if (!empty($this->filter_dep)) {
            $department = Department::find($this->filter_dep);
            if ($department) {
                $majorIds = $department->majors->pluck('id');
                $moduleIds = Module::whereIn('major_id', $majorIds)->pluck('id');
                $professeursQuery->whereIn('module_id', $moduleIds);
            }
        }

        // Apply major filter
        if (!empty($this->filter_fil)) {
            $major = Major::find($this->filter_fil);
            if ($major) {
                $moduleIds = $major->modules->pluck('id');
                $professeursQuery->whereIn('module_id', $moduleIds);
            }
        }

        return view('livewire.admin-dashboard.professeurs', [
            'professeurs' => $professeursQuery->get(),
            'departements' => Department::all(),
            'filieres' => Major::all(),
           'modules' => Module::all(),
        ]);

    }

}
