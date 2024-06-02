<?php

namespace App\Livewire\TeacherDashboard;

use App\Models\Exam;
use App\Models\Classe;
use App\Models\Module;
use App\Models\Teacher;
use App\Models\TeacherAbsence;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Carbon\Carbon;

class TeacherClalendar extends Component
{

    public $currentExam = '';
    public $teacher;
    public $selectedDuration;
    public $showModal = false;
    public $MarkAbsenceModal = false;

    public function mount()
    {
        $this->teacher = Teacher::where('user_id', auth()->user()->id)->first();
    }

    public function getEvents()
    {
        $exams = Exam::where('teacher_id', $this->teacher->id)->get();
        $absences = TeacherAbsence::where('teacher_id', $this->teacher->id)->get();
        // $exams = Exam::all();

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
            return [
                'id' => 'absence-' . $absence->id,
                'title' => 'Absence',
                'start' => $absence->from,
                'end' => $absence->to,
                'teacher' => $this->teacher->user->name,
                'type' => 'absence',
                'className' => 'absence-event',
                'color' => '#ff0000',
            ];
        }));

        return $events->toArray();
    }

    public function showExamDetails($examId)
    {
        $events = $this->getEvents();
        $currentExam = collect($events)
            ->firstWhere('id', $examId);

        $this->currentExam = $currentExam;
        // dd($this->currentExam);

        $this->showModal = true;
    }

    public function updateExamDate($info)
    {
        // dd($info);
        //     array:5 [▼ // app\Livewire\TeacherDashboard\TeacherClalendar.php:79
        //     "allDay" => true
        //     "title" => "Examen en Java"
        //     "start" => "2024-06-04"
        //     "id" => "exam-16"
        //     "extendedProps" => array:3 [▼
        //       "teacher" => "Ibrahim Bensaadoune"
        //       "class" => "LDW1"
        //       "type" => "exam"
        //     ]
        //   ]
        // ! check the event type
        if ($info['extendedProps']['type'] == 'exam') {

            $info['id'] = explode('-', $info['id'])[1];
            $exam = Exam::find($info['id']);

            //? check the exam if it belongs to this teacher
            if ($exam->teacher_id == $this->teacher->id) {
                // dump('gd');
                $exam->update([
                    'date' => $info['start'],
                ]);
                Toaster::success("La date de l'examen a été modifier avec succés");
            } else {
                // dump('ngd');
                Toaster::warning("Erreur");
            }
        } else {
            dd('absence not done yet');
        }
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
        $this->MarkAbsenceModal = true;
        // dd($this->selectedDuration);
    }

    public function confirmAbsence()
    {
        // dd($this->selectedDuration);
        $this->MarkAbsenceModal = false;
        TeacherAbsence::create([
            "teacher_id" => $this->teacher->id,
            "from" => Carbon::parse($this->selectedDuration['start_day']),
            "to" => Carbon::parse($this->selectedDuration['end_day']),
        ]);
        Toaster::success("Votre absence a ete ajoute avec succes");
    }
    public function render()
    {
        return view('livewire.teacher-dashboard.teacher-clalendar');
    }
}
