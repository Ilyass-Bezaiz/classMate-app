<?php

namespace App\Livewire\AdminDashboard;

use App\Models\User;
use App\Models\Classe;
use App\Models\Module;
use App\Models\Teacher;
use Livewire\Component;

class ProfesseurProfile extends Component
{
    public function show($id)
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

        $user = User::findOrFail($id);
        $teacher = Teacher::where('user_id', $user->id)->first();
        $classes = $teacher->classes;
        $exams = $teacher->exams;
        // dd($teacher->exams);
        return view('livewire.admin-dashboard.professeur-profile', [
            'user' => $user,
            'modules' => Module::where('id', $user->getTeacherByUserId($user->id)->module_id)->get(),
            'classes' => $classes,
            'exams' => $exams,
        ]);
    }
}
