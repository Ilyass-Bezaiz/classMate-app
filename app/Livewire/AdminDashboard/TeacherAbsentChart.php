<?php

namespace App\Livewire\AdminDashboard;

use App\Models\Teacher;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class TeacherAbsentChart extends Component
{

    public $teacher;
    public $absenceData;

    public function mount($user_id)
    {
        $this->teacher = Teacher::where('user_id', $user_id)->first();
        $this->fetchAbsenceData();
    }

    public function fetchAbsenceData()
    {
        $absences = DB::table('teacher_absences')
            ->where('teacher_id', $this->teacher->id)
            ->get(['from', 'to']);

        $absenceData = [];

        foreach ($absences as $absence) {
            $currentDate = strtotime($absence->from);
            $endDate = strtotime($absence->to);

            while ($currentDate <= $endDate) {
                $month = date('Y-m', $currentDate);

                if (!isset($absenceData[$month])) {
                    $absenceData[$month] = 0;
                }

                $absenceData[$month]++;
                $currentDate = strtotime("+1 day", $currentDate);
            }
        }

        $this->absenceData = collect($absenceData)
            ->map(function ($days, $month) {
                return ['month' => $month, 'absence_days' => $days];
            })
            ->sortBy('month')
            ->values()
            ->toArray();
        // dd($this->absenceData);
    }
    public function render()
    {
        return view('livewire.admin-dashboard.teacher-absent-chart');
    }
}
