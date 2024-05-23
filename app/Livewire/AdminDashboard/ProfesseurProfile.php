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

        // dd($classes);
        $professeur = User::findOrFail($id);
        return view('livewire.admin-dashboard.professeur-profile', [
            'professeur' => $professeur,
            'modules' => Module::where('id', $professeur->getTeacherByUserId($professeur->id)->module_id)->get(),
        ]);
    }
}
