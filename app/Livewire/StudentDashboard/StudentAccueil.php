<?php

namespace App\Livewire\StudentDashboard;

use App\Models\Exam;
use App\Models\Student;
use Livewire\Component;

class StudentAccueil extends Component
{
    public $student;
    public function mount()
    {
        $this->student = Student::firstWhere('user_id', auth()->user()->id);
    }
    public function render()
    {
        $classID = $this->student->classe_id;
        $startDate = now();
        $endDate = now()->addDays(30);

        $exams = Exam::where('classe_id', $classID)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();
        // dd($exams);
        return view(
            'livewire.student-dashboard.student-accueil',
            [
                'exams' => $exams,
            ]
        );
    }
}
