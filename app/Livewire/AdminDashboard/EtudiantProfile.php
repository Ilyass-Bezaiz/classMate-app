<?php

namespace App\Livewire\AdminDashboard;

use App\Models\Exam;
use App\Models\Student;
use App\Models\User;
use Livewire\Component;

class EtudiantProfile extends Component
{
    public function show($id)
    {
        $etudiant = User::findOrFail($id);
        $student = Student::where('user_id', $etudiant->id)->first();
        $exams = Exam::where("classe_id", $student->classe_id)->get();
        // dd($exams);
        return view('livewire.admin-dashboard.etudiant-profile', [
            'etudiant' => $etudiant,
            'exams' => $exams,
        ]);
    }
}
