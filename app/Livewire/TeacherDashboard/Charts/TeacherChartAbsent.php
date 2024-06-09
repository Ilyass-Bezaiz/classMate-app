<?php

namespace App\Livewire\TeacherDashboard\Charts;

use App\Models\Student;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\StudentAbsence;
use Illuminate\Support\Facades\DB;

class TeacherChartAbsent extends Component
{
    public $classesData = [];
    public $teacher;
    public function mount()
    {
        $this->teacher = Teacher::where('user_id', auth()->user()->id)->first();
        $classes = $this->teacher->classes;
        $studentsAbs = [];
        foreach ($classes as $class) {
            $studentIds = $class->students->pluck('id');
            $absences = StudentAbsence::whereIn('student_id', $studentIds)->get();
            $studentsAbs[$class->name] = $absences;
        }

        foreach ($studentsAbs as  $class) {
            foreach ($class as $absence) {
                $student = Student::find($absence->student_id);
                $classId = $student->classe->id;
                $className = $student->classe->name;
                if (!isset($this->classesData[$classId])) {
                    $this->classesData[$classId] = [
                        'class_name' => $className, // Store the class name
                        'sessions' => 0 // Initialize sessions count
                    ];
                }
                $this->classesData[$classId]['sessions'] += $this->calculateAbsentSessions($absence);
            }
        }
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
        return view('livewire.teacher-dashboard.charts.teacher-chart-absent');
    }
}
