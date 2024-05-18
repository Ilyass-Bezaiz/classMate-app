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

        $etudiants = User::latest()->where('role', 'like', 'Student');

        return view('livewire.admin-dashboard.etudiants',[
                'etudiants' => $etudiants->where('name', 'like', "%{$this->search}%")->orderBy('name')->paginate(10),
                'students' => Student::all(),
                'departements' => Department::all(),
                'filieres' => Major::all(),
                'modules' => Module::all(),
            ]
        );
    }


}
