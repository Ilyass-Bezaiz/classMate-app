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
        $professeurs = Teacher::query();
        $teacherUsers = User::where('role', 'Teacher')->where('name', 'like', "%{$this->search}%")->get();
        $professeurs = Teacher::whereIn('user_id', $teacherUsers->pluck('id'));

        // Apply the major filter if selected
        if (!empty($this->filter_fil)) {
            $major = Major::find($this->filter_fil);
            if ($major) {
                $moduleIds = $major->modules->pluck('id');
                $professeurs->whereIn('module_id', $moduleIds);
            }
        }

        // Apply the department filter if selected
        if (!empty($this->filter_dep)) {
            $department = Department::find($this->filter_dep);
            if ($department) {
                $majorIds = $department->majors->pluck('id');
                $moduleIds = Module::whereIn('major_id', $majorIds)->pluck('id');
                $professeurs->whereIn('module_id', $moduleIds);
            }
        }



        return view('livewire.admin-dashboard.professeurs',
            [
                'professeurs' => $professeurs->paginate(10),
                'teachers' => Teacher::all(),
                'departements' => Department::all(),
                'filieres' => Major::all(),
                'modules' => Module::all(),
            ]
        );
    }

}
