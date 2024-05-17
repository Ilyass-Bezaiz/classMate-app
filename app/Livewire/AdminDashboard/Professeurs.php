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
        $professeurs = User::latest()->where('role', 'like', 'Teacher');

        return view('livewire.admin-dashboard.professeurs',
        [
            'professeurs' => $professeurs->latest()->where('name', 'like', "%{$this->search}%")->paginate(10),
            'teachers' => Teacher::all(),
            'departements' => Department::all(),
            'filieres' => Major::all(),
            'modules' => Module::all(),
        ]
    );
    }
}
