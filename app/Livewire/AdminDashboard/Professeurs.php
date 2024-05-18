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
                'professeurs' => $professeurs->where('name', 'like', "%{$this->search}%")->orderBy('name')->paginate(10),
                'teachers' => Teacher::all(),
                'departements' => Department::all(),
                'filieres' => Major::all(),
                'modules' => Module::all(),
            ]
        );
    }

    public function show($id) {
        $professeur = User::findOrFail($id);
        return view('livewire.admin-dashboard.professeurs-show', [
            'professeur' => $professeur,
            'modules' => Module::where('id', $professeur->getTeacherByUserId($professeur->id)->module_id)->get(),
        ]);
    }
}
