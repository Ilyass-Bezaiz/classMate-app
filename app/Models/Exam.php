<?php

namespace App\Models;

use App\Models\Classe;
use App\Models\Module;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['module_id', 'teacher_id', 'classe_id', 'date'];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
