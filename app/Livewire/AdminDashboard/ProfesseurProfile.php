<?php

namespace App\Livewire\AdminDashboard;

use App\Models\User;
use App\Models\Classe;
use App\Models\Module;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\Department;
use Livewire\Attributes\On;
use App\Models\ClassTeacher;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Validate;

class ProfesseurProfile extends Component
{
    public $user;
    public $teacher;
    public $techerClasses;
    public $allClasses;
    public $teacherExams;
    public $classe;
    public $addClassModal = false;
    // public $editModuleModal = false;
    // public $departments;
    // public $selectedDepartment = null;
    // public $allModules;
    // public $selectedModule;

    public function mount($id)
    {
        //!! Retrieve all teachers associated with a class:
        //  $class = Classe::find($classId);
        // $teachers = $class->teachers;

        // !! Retrieve all classes associated with a teacher:
        // $teacher = Teacher::find($teacherId);
        // $classes = $teacher->classes;

        //!! Attach/Detach a teacher to a class:
        // $class = Classe::find(5);
        // $teacher = Teacher::find(21);
        // $class->teachers()->detach($teacher->id);
        // $class->teachers()->attach($teacher->id);

        $this->user = User::findOrFail($id);
        $this->teacher = Teacher::where('user_id', $this->user->id)->first();
        $this->allClasses = Classe::all();
        $this->teacherExams = $this->teacher->exams;
        $this->departments = Department::all();
        $this->fetchClasses();
        // dd($this->techerClasses);
    }

    #[On('getClasses')]
    public function fetchClasses()
    {
        $this->techerClasses = $this->teacher->classes;
    }

    public function addClass()
    {
        $this->validate([
            'classe' => 'required|integer|exists:classes,id',
        ], [
            'classe.required' => 'Vous devez sélectionner une classe.',
            'classe.integer' => 'La valeur sélectionnée doit être un nombre entier.',
            'classe.exists' => 'La classe sélectionnée n\'existe pas.',
        ]);
        ClassTeacher::create([
            'teacher_id' => $this->teacher->id,
            'classe_id' => $this->classe,
        ]);
        $this->reset('classe');
        $this->reset('addClassModal');
        // Emit an event to notify the component that a new class has been added
        $this->dispatch('getClasses');
        Toaster::success('Classe a bien été affectee');
    }

    public function delete($classe_id)
    {
        ClassTeacher::where('classe_id', $classe_id)
            ->where('teacher_id', $this->teacher->id)
            ->delete();

        $this->dispatch('getClasses');
        Toaster::success('supprimé avec succes');
    }

    // public function updatedSelectedDepartment($departmentId)
    // {
    //     // Fetch modules based on selected department
    //     // if (null == $departmentId) dd('gd');
    //     $this->allModules = [];
    //     $majors = Department::findOrFail($departmentId)->majors;

    //     foreach ($majors as $major) {
    //         foreach ($major->modules as $majoeModule) {
    //             $this->allModules[] = $majoeModule;
    //         }
    //     }
    // }

    // public function editModule()
    // {
    //     // dd($this->selectedModule);
    //     $this->validate([
    //         'selectedModule' => 'required|integer|exists:classes,id',
    //     ], [
    //         'selectedModule.required' => 'Vous devez sélectionner une module.',
    //         'selectedModule.integer' => 'La valeur sélectionnée doit être un nombre entier.',
    //         'selectedModule.exists' => 'La module sélectionnée n\'existe pas.',
    //     ]);
    //     $this->teacher->update([
    //         'module_id' => $this->selectedModule,
    //     ]);
    //     // $this->reset('departments');
    //     $this->reset('selectedModule');
    //     $this->reset('editModuleModal');
    //     // Emit an event to notify the component that a new class has been added
    //     $this->dispatch('getClasses');
    //     Toaster::success('Module a bien été affectee');
    // }
    public function render()
    {
        return view('livewire.admin-dashboard.professeur-profile', [
            'user' => $this->user,
            'teacherModule' => Module::find($this->teacher->module_id),
            'classes' => $this->techerClasses,
            'allClasses' => $this->allClasses,
            'exams' => $this->teacherExams,
            // 'modules' => Module::where('id', $this->teacher->id)->get(),
        ]);
    }
}
