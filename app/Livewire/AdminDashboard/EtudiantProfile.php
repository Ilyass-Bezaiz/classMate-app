<?php

namespace App\Livewire\AdminDashboard;

use App\Models\User;
use Livewire\Component;

class EtudiantProfile extends Component
{
    public function show($id) {
        $etudiant = User::findOrFail($id);
        return view('livewire.admin-dashboard.etudiant-profile', [
            'etudiant' => $etudiant,
        ]);
    }
}
