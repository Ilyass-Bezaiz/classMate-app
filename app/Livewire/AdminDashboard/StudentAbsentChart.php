<?php

namespace App\Livewire\AdminDashboard;

use App\Models\Student;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class StudentAbsentChart extends Component
{
    public $student;
    public $absenceData = [];

    public function mount($user_id)
    {
        $this->student = Student::where('user_id', $user_id)->first();
        $this->fetchAbsenceData();
    }

    public function calculateAbsentSessions($absences)
    {
        $sessionCount = 0;
        // ! $absences variable is each student absence on the student_absences table
        foreach ($absences as $absence) {
            // dump($absence->time);
            $timeRange = explode('-', $absence->time);
            $startHour = (int)$timeRange[0];
            $endHour = (int)$timeRange[1];

            // Calculate the number of sessions based on the time range
            $sessionCount += ($endHour - $startHour);
            // dump($sessionCount);
        }

        return $sessionCount;
    }

    public function fetchAbsenceData()
    {
        $absences = DB::table('student_absences')
            ->select('date', 'time')
            ->where('student_id', $this->student->id)
            ->get();

        $absenceData = [];

        foreach ($absences as $absence) {
            $month = date('m', strtotime($absence->date));
            if (!isset($absenceData[$month])) {
                $absenceData[$month] = 0;
            }
            $absenceData[$month] += $this->calculateAbsentSessions([$absence]);
        }

        $this->absenceData = collect($absenceData)->map(function ($count, $month) {
            return [
                'month' => (int)$month,
                'absence_count' => $count,
            ];
        })->values()->toArray();
        // dd($this->absenceData);
    }
    public function render()
    {
        return view('livewire.admin-dashboard.student-absent-chart', [
            'student' => $this->student,
            'absenceData' => $this->absenceData,
        ]);
    }
}
