<?php

namespace App\Livewire\TeacherDashboard;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Classe;
use App\Models\Major;
use App\Models\Module;
use App\Models\Notification;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\TeacherAbsence;
use Masmerise\Toaster\Toaster;

class TeacherClalendar extends Component
{

    public $events = [];
    public $selectedEvent;
    public $teacher;
    public $selectedDuration;
    public $classes = [];
    public $modules = [];
    public $examClass;
    public $examModule;
    public $selectedDate;
    public $editedExam;
    public $showModal = false;
    public $MarkAbsenceModal = false;
    public $editExamModal = false;
    public $dayClickModal = false;

    public function mount()
    {
        $this->teacher = Teacher::where('user_id', auth()->user()->id)->first();
        $this->classes = $this->teacher->classes;
        $this->getEvents();
    }

    public function getEvents()
    {
        $exams = Exam::where('teacher_id', $this->teacher->id)->get();
        $absences = TeacherAbsence::where('teacher_id', $this->teacher->id)->get();

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
                'title' => 'Absence',
                'start' => $absence->from,
                'end' => Carbon::parse($absence->to)->addDay()->format('Y-m-d'),
                'start_day' => $start_day->locale('fr_FR')->isoFormat('LL'),
                'end_day' => $end_day->locale('fr_FR')->isoFormat('LL'),
                'duration' => $duration,
                'teacher' => $this->teacher->user->name,
                'type' => 'absence',
                'className' => 'absence-event',
                // 'color' => '#ff0000',
            ];
        }));
        $this->events = $events->toArray();
    }

    public function showEventDetails($eventID)
    {
        // dd($eventID);
        $selectedEvent = collect($this->events)
            ->firstWhere('id', $eventID);

        $this->selectedEvent = $selectedEvent;
        // dd($this->selectedEvent);

        $this->showModal = true;
    }

    public function updateEventDate($info)
    {
        // dd($info);
        // ! check the event type
        if ($info['extendedProps']['type'] == 'exam') {

            $info['id'] = explode('-', $info['id'])[1];
            $exam = Exam::find($info['id']);

            //? check the exam if it belongs to this teacher
            if ($exam->teacher_id == $this->teacher->id) {
                $exam->update([
                    'date' => $info['start'],
                ]);
                Toaster::success("La date de l'examen a été modifier avec succés");
            } else {
                Toaster::warning("Erreur");
            }
        } else {
            $info['id'] = explode('-', $info['id'])[1];
            $absence = TeacherAbsence::find($info['id']);
            //? check the exam if it belongs to this teacher
            if ($absence->teacher_id == $this->teacher->id) {
                $absence->update([
                    'from' => $info['start'],
                    'to' => Carbon::parse($info['end'])->subDay()->format('Y-m-d'),
                ]);
                Toaster::success("La date de l'absence a été modifier avec succés");
            } else {
                Toaster::warning("Erreur");
            }
        }
    }

    public function addExam()
    {
        $this->MarkAbsenceModal = false;
        $this->validate([
            'examClass' => 'required|integer|exists:classes,id',
            'examModule' => 'required|integer|exists:Modules,id',
        ], [
            'examClass.required' => 'Vous devez sélectionner une classe.',
            'examClass.integer' => 'La valeur sélectionnée doit être un nombre entier.',
            'examClass.exists' => 'La classe sélectionnée n\'existe pas.',
            'examModule.required' => 'Vous devez sélectionner un module.',
            'examModule.integer' => 'La valeur sélectionnée doit être un nombre entier.',
            'examModule.exists' => 'Le module sélectionné n\'existe pas.',
        ]);
        //create exam
        $exam = Exam::create([
            "module_id" => $this->examModule,
            "teacher_id" => $this->teacher->id,
            "classe_id" => $this->examClass,
            "date" => $this->selectedDate,
        ]);
        //send message
        $class = Classe::find($this->examClass);
        $students = $class->students;
        foreach ($students as $student) {
            Notification::create([
                'sender_id' => $this->teacher->id,
                'receiver_id' => $student->id,
                'message' => "Vous aurez examen le: $this->selectedDate",
            ]);
        }
        //update calendar via event
        $eventData = [
            'id' => 'exam-' . $exam->id,
            'title' => 'Examen en ' . Module::find($exam->module_id)->name,
            'start' => $exam->date->format('Y-m-d'),
            'teacher' => Teacher::find($exam->teacher_id)->user->name,
            'class' => Classe::find($exam->classe_id)->name,
            'type' => 'exam',
        ];
        $this->dayClickModal = false;
        Toaster::success("Examen a ete ajoute avec succes");
        $this->dispatch('eventAdded', json_encode($eventData));
        $this->examModule = '';
        $this->examClass = '';
        $this->selectedDate = '';
        $this->getEvents();
    }

    public function editEvent($info)
    {
        // $tableInfo = json_decode($info);
        // dd($info);
        $type = explode('-', $info)[0]; //absence
        $id = explode('-', $info)[1]; //16
        if ($type == 'exam') {
            $this->editedExam = Exam::find($id);
            $this->examClass = $this->editedExam->classe_id;
            $class = Classe::find($this->examClass);
            $classMajor = Major::find($class->major->id);
            $this->modules = $classMajor->modules;
            $this->examModule = $this->editedExam->module_id;

            // dd($this->examModule);
            $this->editExamModal = true;
        }
    }

    public function ConfirmEdit()
    {
        $this->editExamModal = false;
        $this->editedExam->update([
            'module_id' => $this->examModule,
            'classe_id' => $this->examClass,
        ]);
        Toaster::success('exam modifie avec succes');
        $this->getEvents();
    }
    public function updatedExamClass()
    {
        $class = Classe::find($this->examClass);
        $classMajor = Major::find($class->major->id);
        $this->modules = $classMajor->modules;
    }

    public function showMultipleSelectModal($start_day_str, $end_day_str)
    {
        $end_day = date('Y-m-d', strtotime($end_day_str . ' -1 day'));
        $start_day = Carbon::parse($start_day_str);
        $end_day = Carbon::parse($end_day);
        // Calculate the duration
        $duration = $end_day->diff($start_day)->days + 1;

        $this->selectedDuration = [
            'start_day' =>  $start_day,
            'end_day' => $end_day,
            'start' => $start_day->locale('fr_FR')->isoFormat('LL'),
            'end' => $end_day->locale('fr_FR')->isoFormat('LL'),
            'duration' => $duration,
        ];
        $this->MarkAbsenceModal = $duration == 1 ? false : true;
    }

    public function confirmAbsence()
    {
        // dd($this->selectedDuration);
        $this->MarkAbsenceModal = false;
        $this->dayClickModal = false;
        $lastAbsence = TeacherAbsence::create([
            "teacher_id" => $this->teacher->id,
            "from" => Carbon::parse($this->selectedDuration['start_day']),
            "to" => Carbon::parse($this->selectedDuration['end_day']),
        ]);

        $eventData = [
            'id' => 'absence-' . $lastAbsence->id,
            'title' => 'Absence',
            'start' => Carbon::parse($lastAbsence->from)->format('Y-m-d'),
            'end' => Carbon::parse($lastAbsence->to)->addDay()->format('Y-m-d'),
            'teacher' => $this->teacher->user->name,
            'type' => 'absence',
            'className' => 'absence-event',
        ];
        $this->dispatch('eventAdded', json_encode($eventData));
        Toaster::success("Votre absence a ete ajoute avec succes");
        $this->getEvents();
    }

    public function updateEventDuration($info)
    {
        $oldEvent = $info['oldEvent'];
        $event = $info['event'];
        $eventType = explode('-', $event['id'])[0]; //absence
        $id = explode('-', $event['id'])[1]; //16
        // dd($event);
        if ($eventType = 'absence') {
            $absence = TeacherAbsence::find($id);
            // dd(Carbon::parse($event['end'])->subDay()->format('Y-m-d'));
            $absence->update([
                'from' => $event['start'],
                'to' => Carbon::parse($event['end'])->subDay()->format('Y-m-d'),
            ]);
            Toaster::success("Duree d'absence a ete modifier avec succes");
        }
    }

    public function deleteEvent($info)
    {
        // dd($info);
        //type-id => absence-16
        $type = explode('-', $info)[0]; //absence
        $id = explode('-', $info)[1]; //16

        if ($type == 'exam') {
            $exam = Exam::find($id);
            // dd($exam);
            //? check the exam if it belongs to this teacher
            if ($exam->teacher_id == $this->teacher->id) {
                // dump('gd');
                $exam->delete();
                $this->dispatch('eventDeleted', $info);
                Toaster::success("L'examen a été supprimer avec succés");
            } else {
                // dump('ngd');
                Toaster::warning("Erreur");
            }
        } else {
            $absence = TeacherAbsence::find($id);

            //? check the absence if it belongs to this teacher
            if ($absence->teacher_id == $this->teacher->id) {
                $absence->delete();
                $this->dispatch('eventDeleted', $info);
                Toaster::success("L'absence a été supprimer avec succés");
            } else {
                Toaster::warning("Erreur");
            }
        }
    }
    public function render()
    {
        return view('livewire.teacher-dashboard.teacher-clalendar');
    }
}
