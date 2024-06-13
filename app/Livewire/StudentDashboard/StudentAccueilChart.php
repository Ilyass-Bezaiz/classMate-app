<?php

namespace App\Livewire\StudentDashboard;

use App\Models\Student;
use Livewire\Component;
use App\Models\StudentAbsence;
use App\Models\Teacher;

class StudentAccueilChart extends Component
{
    public $student;
    public $absenceSessionPerTeacher = [];

    public function mount()
    {
        $this->student = Student::firstWhere('user_id', auth()->user()->id);
        $absences = StudentAbsence::where('student_id', $this->student->id)->get();
        foreach ($absences as $absence) {
            $teacherName = Teacher::find($absence->teacher_id)->user->name;
            if (!isset($this->absenceSessionPerTeacher[$teacherName])) {
                $this->absenceSessionPerTeacher[$teacherName] = [
                    'teache_name' => $teacherName, // Store the class name
                    'sessions' => 0 // Initialize sessions count
                ];
            }
            $this->absenceSessionPerTeacher[$teacherName]['sessions'] += $this->calculateAbsentSessions($absence);
        }
        // dd($this->absenceSessionPerTeacher);
    }

    public function calculateAbsentSessions($absence)
    {
        $sessionCount = 0;
        // ! $absences variable is each student absence on the student_absences table
        $timeRange = explode('-', $absence->time);
        $startHour = (int)$timeRange[0];
        $endHour = (int)$timeRange[1];
        $sessionCount += ($endHour - $startHour);
        return $sessionCount;
    }
    public function render()
    {
        return view('livewire.student-dashboard.student-accueil-chart');
    }
}
