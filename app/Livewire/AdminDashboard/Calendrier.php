<?php

namespace App\Livewire\AdminDashboard;

use App\Models\Classe;
use App\Models\Exam;
use App\Models\Module;
use App\Models\Teacher;
use Livewire\Component;

class Calendrier extends Component
{
    public $currentExam = '';
    public $selectedDate;
    public $newExamTitle;
    public $showModal = false;
    public $showCreateModal = false;

    public function getEvents()
    {
        $exams = Exam::all();

        $events = $exams->map(function (Exam $exam) {
            return [
                'id' => $exam->id,
                'title' => 'Examen en ' . Module::find($exam->module_id)->name,
                'start' => $exam->date->format('Y-m-d'),
                'teacher' => Teacher::find($exam->teacher_id)->user->name,
                'class' => Classe::find($exam->classe_id)->name,
            ];
        });

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

    public function showCreateExamModal($date)
    {
        // dd($date);
        $this->showCreateModal = true;
    }

    public function showMultipleSelectModal($start_day, $end_date)
    {
        // dd($start_day, $end_date);
        $this->showCreateModal = true;
    }

    public function render()
    {
        return view('livewire.admin-dashboard.calendrier');
    }
}
