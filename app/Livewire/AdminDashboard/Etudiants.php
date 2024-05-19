<?php

namespace App\Livewire\AdminDashboard;

use App\Models\User;
use App\Models\Major;
use App\Models\Classe;
use App\Models\Module;
use App\Models\Student;
use Livewire\Component;
use App\Models\Department;

class Etudiants extends Component
{
    public $search;
    public $filter_dep;
    public $filter_fil;
    public function render()
    {
        $etudiants = Student::query();
        $etudiantUsers = User::where('role', 'Student')->where('name', 'like', "%{$this->search}%")->get();
        $etudiants = Student::whereIn('user_id', $etudiantUsers->pluck('id'));

        // Apply the major filter if selected
        if (!empty($this->filter_fil)) {
            $major = Major::find($this->filter_fil);
            if ($major) {
                $classeIds = $major->classes->pluck('id');
                $etudiants->whereIn('classe_id', $classeIds);
            }
        }

        // Apply the department filter if selected
        if (!empty($this->filter_dep)) {
            $department = Department::find($this->filter_dep);
            if ($department) {
                $majorIds = $department->majors->pluck('id');
                $classeIds = Classe::whereIn('major_id', $majorIds)->pluck('id');
                $etudiants->whereIn('classe_id', $classeIds);
            }
        }



        return view('livewire.admin-dashboard.etudiants',[
                'etudiants' => $etudiants->paginate(10),
                'students' => Student::all(),
                'departements' => Department::all(),
                'filieres' => Major::all(),
                'modules' => Module::all(),
            ]
        );
    }


}
