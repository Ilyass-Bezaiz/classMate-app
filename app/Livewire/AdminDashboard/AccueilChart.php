<?php

namespace App\Livewire\AdminDashboard;

use Livewire\Component;
use App\Models\StudentAbsence;
use App\Models\TeacherAbsence;
use Illuminate\Support\Facades\DB;

class AccueilChart extends Component
{

    public $absencesPerDepartment;

    public function mount()
    {
        $this->absencesPerDepartment = DB::table('student_absences')
            ->join('students', 'student_absences.student_id', '=', 'students.id')
            ->join('classes', 'students.classe_id', '=', 'classes.id')
            ->join('majors', 'classes.major_id', '=', 'majors.id')
            ->join('departments', 'majors.department_id', '=', 'departments.id')
            ->select('departments.name as department', DB::raw('COUNT(DISTINCT students.id) as absence_count'))
            ->groupBy('departments.name')
            ->orderBy('absence_count', 'desc')
            ->get();
        // dd($this->absencesPerDepartment);
    }

    public function render()
    {
        return view('livewire.admin-dashboard.accueil-chart');
    }
}
