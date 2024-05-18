<?php

namespace App\Models;

use App\Models\User;
use App\Models\Classe;
use App\Models\StudentAbsence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['CNE', 'user_id', 'classe_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function studentAbsences()
    {
        return $this->hasMany(StudentAbsence::class);
    }

    
}
