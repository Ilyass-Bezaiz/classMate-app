<?php

namespace App\Livewire\AdminDashboard;

use App\Models\Classe;
use App\Models\Student;
use Livewire\Component;

class ClassDetails extends Component
{

    public $class;

    public function mount($id)
    {
        // ? get the classe by id with its major and the major's department
        // ? get the class students with their absences
        $this->class = Classe::with('major.department', 'students.studentAbsences')->findOrFail($id);
        // dd($this->class);
    }

    // ! function to calculate the students absence sessions
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

    public function render()
    {
        $students = $this->class->students;

        // Calculate the number of absent sessions for each student
        foreach ($students as $student) {
            $student->absent_sessions = $this->calculateAbsentSessions($student->studentAbsences);
        }

        // dd($students);
        // dd(Student::find(45)->studentAbsences);
        return view('livewire.admin-dashboard.class-details', [
            'class' => $this->class,
            'students' => $students
        ]);
    }
}
