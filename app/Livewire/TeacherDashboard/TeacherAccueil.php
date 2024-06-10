<?php

namespace App\Livewire\TeacherDashboard;

use App\Models\Exam;
use App\Models\Student;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\StudentAbsence;
use Illuminate\Support\Facades\DB;

class TeacherAccueil extends Component
{
    public $teacher;
    public function mount()
    {
        $this->teacher = Teacher::where('user_id', auth()->user()->id)->first();
    }

    public function calculateAbsentSessions($absence)
    {
        $sessionCount = 0;
        // ! $absences variable is each student absence on the student_absences table
        $timeRange = explode('-', $absence->time);
        $startHour = (int)$timeRange[0];
        $endHour = (int)$timeRange[1];
        // Calculate the number of sessions based on the time range
        $sessionCount += ($endHour - $startHour);

        return $sessionCount;
    }
    public function render()
    {
        // $studentsAbs = StudentAbsence::where('teacher_id', $this->teacher->id)
        //     ->take(4)
        //     ->get();

        $classes = $this->teacher->classes;
        $studentsData = [];
        $studentsAbs = [];
        foreach ($classes as $class) {
            $studentIds = $class->students->pluck('id');
            $absences = StudentAbsence::whereIn('student_id', $studentIds)->get();
            $studentsAbs[$class->name] = $absences;
        }

        foreach ($studentsAbs as  $class) {
            foreach ($class as $absence) {
                $studentId = $absence->student_id;
                if (!isset($studentsData[$studentId])) {
                    $student = StudentAbsence::where('student_id', $studentId)->first();
                    $studentsData[$studentId] = $student;
                    $studentsData[$studentId]->sessions = 0;
                }
                $studentsData[$studentId]->sessions += $this->calculateAbsentSessions($absence);
            }
        }
        // dd($studentsAbs);
        $exams = Exam::where('teacher_id', $this->teacher->id)->orderBy('created_at', 'desc')->take(3)->get();
        return view(
            'livewire.teacher-dashboard.teacher-accueil',
            [
                'students' => $studentsData,
                'exams' => $exams
            ]
        );
    }
}
