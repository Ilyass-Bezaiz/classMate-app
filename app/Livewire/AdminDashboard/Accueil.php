<?php

namespace App\Livewire\AdminDashboard;

use App\Models\Exam;
use Livewire\Component;
use App\Models\StudentAbsence;
use App\Models\TeacherAbsence;
use Illuminate\Support\Facades\DB;

class Accueil extends Component
{
    public function render()
    {
        $studentsAbs = StudentAbsence::select('student_id')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('student_id')
            ->orderByDesc('count')
            ->take(4)
            ->get();
        // $teachersAbs = TeacherAbsence::select('teacher_absences.*', DB::raw('TIMESTAMPDIFF(DAY, `from`, `to`) as duration'))
        //     ->with('teacher.user')  // Assuming you have the relationships set up correctly
        //     ->orderByDesc('duration')
        //     ->take(4)
        //     ->get();
        $teachersAbs = TeacherAbsence::select('teacher_id', DB::raw('SUM(TIMESTAMPDIFF(DAY, `from`, `to`)) as duration'))
            ->groupBy('teacher_id')
            ->orderByDesc('duration')
            ->take(4)
            ->get();

        $exams = Exam::orderBy('created_at', 'desc')->take(3)->get();


        // dd($teachersAbs);

        return view(
            'livewire.admin-dashboard.accueil',
            [
                'students' => $studentsAbs,
                'teachers' => $teachersAbs,
                'exams' => $exams
            ]
        );
    }
}
