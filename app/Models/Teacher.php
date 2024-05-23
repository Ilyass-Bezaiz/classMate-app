<?php

namespace App\Models;

use App\Models\Exam;
use App\Models\User;
use App\Models\Module;
use App\Models\StudentAbsence;
use App\Models\TeacherAbsence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['diploma', 'user_id', 'module_id', 'CIN'];

    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'class_teachers');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function studentAbsences()
    {
        return $this->hasMany(StudentAbsence::class);
    }

    public function teacherAbsences()
    {
        return $this->hasMany(TeacherAbsence::class);
    }
}
