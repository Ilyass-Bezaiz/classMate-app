<?php

namespace App\Livewire\AdminDashboard;

use App\Models\User;
use App\Models\Module;
use Livewire\Component;

class ProfesseurProfile extends Component
{
    public function show($id)
    {
        $professeur = User::findOrFail($id);
        return view('livewire.admin-dashboard.professeur-profile', [
            'professeur' => $professeur,
            'modules' => Module::where('id', $professeur->getTeacherByUserId($professeur->id)->module_id)->get(),
        ]);
    }
}
