<?php

namespace App\Livewire\StudentDashboard;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Classe;
use App\Models\Module;
use App\Models\Student;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\TeacherAbsence;

class StudentCalendar extends Component
{

    public $showModal = false;
    public $selectedEvent;
    public $events;
    public $student;

    public function mount()
    {
        $this->student = Student::where('user_id', auth()->user()->id)->first();
        $this->getEvents();
    }

    public function getEvents()
    {
        $exams = Exam::where('classe_id', $this->student->classe_id)->get();
        $class = Classe::find($this->student->classe_id);
        $teachers = $class->teachers;
        $teacherIds = $teachers->pluck('id');

        $absences = TeacherAbsence::whereIn('teacher_id', $teacherIds)->get();
        $events = collect();

        // Add exams to the events
        $events = $events->merge($exams->map(function (Exam $exam) {
            return [
                'id' => 'exam-' . $exam->id,
                'title' => 'Examen en ' . Module::find($exam->module_id)->name,
                'start' => $exam->date->format('Y-m-d'),
                'teacher' => Teacher::find($exam->teacher_id)->user->name,
                'class' => Classe::find($exam->classe_id)->name,
                'type' => 'exam',
            ];
        }));

        // Add absences to the events
        $events = $events->merge($absences->map(function (TeacherAbsence $absence) {
            $start_day = Carbon::parse($absence->from);
            $end_day = Carbon::parse($absence->to);
            // Calculate the duration
            $duration = $end_day->diff($start_day)->days + 1;
            // dd($start_day, $end_day, $duration);
            return [
                'id' => 'absence-' . $absence->id,
                'title' => 'Absence professeur ' .  $absence->teacher->user->name,
                'start' => $absence->from,
                'end' => Carbon::parse($absence->to)->addDay()->format('Y-m-d'),
                'start_day' => $start_day->locale('fr_FR')->isoFormat('LL'),
                'end_day' => $end_day->locale('fr_FR')->isoFormat('LL'),
                'duration' => $duration,
                'teacher' => $absence->teacher->user->name,
                'type' => 'absence',
            ];
        }));
        $this->events = $events->toArray();
    }

    public function showEventDetails($eventID)
    {
        $selectedEvent = collect($this->events)
            ->firstWhere('id', $eventID);
        $this->selectedEvent = $selectedEvent;
        $this->showModal = true;
    }
    public function render()
    {
        return view('livewire.student-dashboard.student-calendar');
    }
}
