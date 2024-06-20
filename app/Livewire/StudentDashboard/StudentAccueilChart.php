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
            $moduleName = Teacher::find($absence->teacher_id)->module->name;
            if (!isset($this->absenceSessionPerTeacher[$moduleName])) {
                $this->absenceSessionPerTeacher[$moduleName] = [
                    'module_name' => $moduleName,
                    'sessions' => 0
                ];
            }
            $this->absenceSessionPerTeacher[$moduleName]['sessions'] += $this->calculateAbsentSessions($absence);
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
