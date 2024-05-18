<?php

namespace App\Models;

use App\Models\Exam;
use App\Models\Major;
use App\Models\Teacher;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'major_id'];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function getMajorByModuleId(int $id) {
        return Major::where('id', $id)->first();
    }

    public function getDepartementByModuleId(int $id) {
        $majorId = $this->getMajorByModuleId($id)->department_id;
        return Department::where('id', $majorId)->first();
    }
}
