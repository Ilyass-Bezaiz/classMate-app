<?php

namespace App\Livewire\TeacherDashboard;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Classe;
use App\Models\Student;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\StudentAbsence;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Auth;

class TeacherClasses extends Component
{
    public $selectedClassId;
    public $search;

    public $selectedDate;
    public $selectedPresence;

    public $dates = [];

    public $sessionPeriod;

    public $teacherClasses;

    public function mount()
    {
        Carbon::setLocale('fr');
        $teacher = Teacher::where('user_id', Auth::user()->id)->first();
        $this->teacherClasses = $teacher->classes;
        $this->selectedClassId = $this->teacherClasses[0]->id;
        $this->selectedDate = Carbon::today()->toDateString();
        $this->dates = $this->getFormattedDates();
        $this->sessionPeriod = 1;
    }

    public function changeDate($newDate)
    {
        $this->selectedDate = $newDate;
    }

    public function getFormattedDates()
    {
        $dates = [];
        $endDate = Carbon::today();
        $startDate = $endDate->copy()->subDays(4);

        while ($startDate->lte($endDate)) {
            $formattedDate = $startDate->translatedFormat('d M');
            $dates[] = [
                'date' => $startDate->toDateString(),
                'formatted' => $formattedDate,
            ];
            $startDate->addDay();
        }

        return $dates;
    }

    public function checkAbsence($studentId)
    {
        // Set default values if not provided
        $date = $this->selectedDate;
        $currentHour = Carbon::now()->addHour()->hour;
        $nextHour = $currentHour + $this->sessionPeriod;
        $timeSlot = $timeSlot ?? sprintf('%02d-%02d', $currentHour, $nextHour);

        // Check if the student is absent
        $absenceRecord = StudentAbsence::where('student_id', $studentId)
            ->where('date', $date)
            ->where('time', $timeSlot)
            ->first();

        if ($absenceRecord) {
           return  $absenceRecord->is_absent === 0 ? 'present' : 'absent';
        } else {
            return 'unrecorded';
        }
    }

    public function marqueAbsence($studentId, $isAbsent)
    {
        // Calculate the time slot based on the current hour
        $currentHour = Carbon::now()->addHour()->hour;
        $nextHour = $currentHour + $this->sessionPeriod;
        $absenceTime = sprintf('%02d-%02d', $currentHour, $nextHour);

        // Check if the absence record already exists
        $existingAbsence = StudentAbsence::where('student_id', $studentId)
            ->where('teacher_id', Teacher::where('user_id', Auth::user()->id)->first()->id)
            ->where('date', $this->selectedDate)
            ->where('time', $absenceTime)
            ->first();

        if ($existingAbsence) {
            // Update the existing record
            $existingAbsence->is_absent =  $isAbsent == 'true' ? true : false;
            $existingAbsence->save();

            Toaster::success('Absence mis à jour avec succès.');
        } else {
            // Create a new absence record
            $absence = new StudentAbsence();
            $absence->student_id = $studentId;
            $absence->teacher_id = Teacher::where('user_id', Auth::user()->id)->first()->id;
            $absence->is_absent =  $isAbsent == 'true' ? true : false;
            $absence->date = $this->selectedDate;
            $absence->time = $absenceTime;
            $absence->save();

            Toaster::success('Absence enregistrée avec succès.');
        }
    }

    public function render()
    {
        $studentUsers = User::where('role', 'Student')->where('name', 'like', "%{$this->search}%")->get();
        $students = $this->teacherClasses->firstWhere('id', $this->selectedClassId)->students->whereIn('user_id', $studentUsers->pluck('id'));

        return view('livewire.teacher-dashboard.teacher-classes',[
            'classes' => $this->teacherClasses,
            'students' => $students,
        ]);
    }

    public function changeClass($id)
    {
        // dd($this->selectedClassId);
        $this->selectedClassId = $id;
    }

}

