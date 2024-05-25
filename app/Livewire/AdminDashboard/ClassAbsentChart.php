<?php

namespace App\Livewire\AdminDashboard;

use App\Models\Student;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ClassAbsentChart extends Component
{
    public $classId;
    public $students = [];
    public $classAbsenceData = [];

    public function mount($classId)
    {
        $this->classId = $classId;
        $this->fetchStudents();
        $this->fetchClassAbsenceData();
    }

    public function fetchStudents()
    {
        // Fetch students based on the provided class ID
        $this->students = Student::where('classe_id', $this->classId)->get();
    }

    public function fetchClassAbsenceData()
    {

        $classAbsenceData = [];

        foreach ($this->students as $student) {
            $absences = DB::table('student_absences')
                ->select('date', 'time')
                ->where('student_id', $student->id)
                ->get();

            foreach ($absences as $absence) {
                $month = date('m', strtotime($absence->date));
                if (!isset($classAbsenceData[$month])) {
                    $classAbsenceData[$month] = 0;
                }
                $classAbsenceData[$month] += $this->calculateAbsentSessions([$absence]);
            }
        }

        $this->classAbsenceData = collect($classAbsenceData)->map(function ($count, $month) {
            return [
                'month' => (int)$month,
                'absence_count' => $count,
            ];
        })->values()->toArray();
    }

    public function calculateAbsentSessions($absences)
    {
        $sessionCount = 0;

        foreach ($absences as $absence) {
            $timeRange = explode('-', $absence->time);
            $startHour = (int)$timeRange[0];
            $endHour = (int)$timeRange[1];

            $sessionCount += ($endHour - $startHour);
        }

        return $sessionCount;
    }

    public function render()
    {
        return view('livewire.admin-dashboard.class-absent-chart', [
            'classAbsenceData' => $this->classAbsenceData,
        ]);
    }

}
