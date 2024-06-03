<?php

namespace App\Livewire\AdminDashboard;

use Carbon\Carbon;
use App\Models\Major;
use App\Models\Classe;
use App\Models\Student;
use App\Models\Teacher;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ClassDetails extends Component
{

    public $class;

    public $showEdit = false;
    public $deletingClass = false;

    public $addingTeacher = false;
    public $deletingTeacher = false;
    public $editingTeacherId;
    public $editingTeacherModule;
    public $deletingTeacherId;

    public $addingStudent = false;
    public $deletingStudent = false;
    public $editingStudent = false;

    #[Validate('required', message: 'Veuillez choisir une classe')]
    public $editingStudentClass;
    public $editingStudentId;
    public $deletingStudentId;



    #[Validate('required', message: 'Veuillez entrer un nom pour la classe')]
    #[Validate('min:3', message: 'Le nom doit avoir au moins 3 caractères')]
    #[Validate('max:25', message: 'Le nom doit avoir au plus 25 caractères')]
    public $name;

    #[Validate('required', message: 'Veuillez choisir une filière pour la classe')]
    public $classFil;

    #[Validate('required', message: "Veuillez saisir l'année scolaire")]
    public $schoolYear;

    #[Validate('required', message: "Veuillez saisir votre mot de passe")]
    public $adminPassword;

    // affecte professeurs attributes
    #[Validate('required', message: "Veuillez choisir un professeur")]
    public $newProfesseur;

    #[Validate('required', message: "Veuillez choisir le module")]
    public $profModule;

    // ajouter etudiant attributes
    #[Validate('required', message: "Veuillez choisir un étudiant")]
    public $newEtudiant;

    public function mount($id)
    {
        // ? get the classe by id with its major and the major's department
        // ? get the class students with their absences
        $this->class = Classe::with('major.department', 'students.studentAbsences', 'teachers.teacherAbsences')->findOrFail($id);
        $this->name = Classe::find($id)->name;
        $this->classFil = Classe::find($id)->major_id;
        $this->schoolYear = Classe::find($id)->school_year;
        // dd($this->class);
    }

    // ! function to calculate the students absence sessions
    public function calculateStudentAbsentSessions($absences)
    {
        $sessionCount = 0;
        // ! $absences variable is each student absence on the student_absences table
        // dd($absences);
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
    public function calculateTeacherAbsence($absences)
    {
        Carbon::setLocale('fr');
        $totalTime = 0;
        // ! $absences variable is each teacher absence on the teacher_absences table
        foreach ($absences as $absence) {
            $startDay = Carbon::parse($absence->from);
            $endDay = Carbon::parse($absence->to);

            $totalTime = $startDay->diffForHumans($endDay, ['syntax' => Carbon::DIFF_ABSOLUTE]);
            // dump($totalTime);
        }

        return $totalTime;
    }

    public function render()
    {
        $students = $this->class->students;
        $professeurs = $this->class->teachers;

        // Calculate the number of absent sessions for each student
        foreach ($students as $student) {
            $student->absent_sessions = $this->calculateStudentAbsentSessions($student->studentAbsences);
        }

        foreach ($professeurs as $teacher) {
            $teacher->absent_sessions = $this->calculateTeacherAbsence($teacher->teacherAbsences);
        }

        // dd($students);
        // dd(Student::find(45)->studentAbsences);
        return view('livewire.admin-dashboard.class-details', [
            'class' => $this->class,
            'professeurs' => $professeurs,
            'students' => $students,
            'filieres' => Major::all(),
        ]);
    }

    public function update()
    {
        $this->validateOnly('name');
        $this->validateOnly('classFil');
        $this->validateOnly('schoolYear');
        try {
            Classe::find($this->class->id)->update([
                'name'=> $this->name,
                'major_id'=> $this->classFil,
                'school_year'=> $this->schoolYear,
            ]);
            $this->reset('showEdit');
            $this->mount($this->class->id);
            Toaster::success('La classe a bien été modifiée');
        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
    }

    public function updateTeacherModule()
    {
        try {
            Teacher::find($this->editingTeacherId)->update([
                'module_id'=> $this->editingTeacherModule,
            ]);
            Toaster::success('Le module de professeur a bien été modifiée');
        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
    }

    public function deleteTeacherFromClass() {
        $user = Auth::user();
        $this->validateOnly('adminPassword');
        try {
            if (password_verify($this->adminPassword, $user->password)) {
                Classe::find($this->class->id)->teachers()->detach($this->deletingTeacherId);
                $this->cancelDeleting();
                Toaster::success('Le professeur a bien été retirée.');
            } else {
                $this->addError('adminPassword', 'Le mot de passe est incorrect.');
            }

        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
    }

    public function deleteStudentFromClasse()
    {
        $user = Auth::user();
        $this->validateOnly('adminPassword');
        try {
            if (password_verify($this->adminPassword, $user->password)) {
                Student::find($this->deletingStudentId)->update([
                    'classe_id'=> null,
                ]);
                $this->cancelDeleting();
                Toaster::success('L\'étudiant a bien été retirée.');
            } else {
                $this->addError('adminPassword', 'Le mot de passe est incorrect.');
            }

        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
    }

    public function ChangeStudentClasse()
    {
        $user = Auth::user();
        $this->validateOnly('adminPassword');
        $this->validateOnly('editingStudentClass');
        try {
            if (password_verify($this->adminPassword, $user->password)) {
                Student::find($this->editingStudentId)->update([
                    'classe_id'=> $this->editingStudentClass,
                ]);
                $this->reset('editingStudent', 'editingStudentId', 'editingStudentClass');
                Toaster::success('L\'étudiant a bien été transféré.');
            } else {
                $this->addError('adminPassword', 'Le mot de passe est incorrect.');
            }

        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
    }

    public function delete()
    {
        $user = Auth::user();
        $this->validateOnly('adminPassword');
        try {
            if (password_verify($this->adminPassword, $user->password)) {
                Classe::find($this->class->id)->delete();
                Redirect::route('classes')->success('La classe a bien été supprimer');
            } else {
                $this->addError('adminPassword', 'Le mot de passe est incorrect.');
            }
        } catch (\Exception $e) {
            Toaster::error('Une erreur est servenu');
            throw $e;
        }
    }

    public function cancelDeleting()
    {
        $this->reset('deletingTeacher', 'deletingTeacherId');
        $this->reset('deletingStudent', 'deletingStudentId');
    }

    public function affecteTeacher() {
        $this->validateOnly('newProfesseur');
        $this->validateOnly('profModule');
        try {
            Teacher::find($this->newProfesseur)->update([
                'module_id' => $this->profModule,
            ]);
            Classe::find($this->class->id)->teachers()->attach($this->newProfesseur);
            Toaster::success('Le professeur a bien été affecté');
        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
        $this->reset('newProfesseur', 'profModule');
        $this->reset('addingTeacher');
    }

    public function ajouterEtudiant() {
        $this->validateOnly('newEtudiant');
        try {
            Student::find($this->newEtudiant)->update([
                'classe_id' => $this->class->id,
            ]);
            Toaster::success('L\'étudiant a bien été ajouté');
        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
        $this->reset('newEtudiant');
        $this->reset('addingStudent');
    }
}
