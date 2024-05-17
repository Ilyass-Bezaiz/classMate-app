<?php

namespace App\Models;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherAbsence extends Model
{
    use HasFactory;

    protected $fillable = ['teacher_id', 'from', 'to'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
