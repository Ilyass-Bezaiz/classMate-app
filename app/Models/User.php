<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Major;
use App\Models\Module;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Department;
use App\Models\Administrator;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'profile_photo_path', 'password', 'role'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = ['profile_photo_url'];

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function administrators()
    {
        return $this->hasMany(Administrator::class);
    }

    public function getTeacherByUserId(int $id)
    {
        return Teacher::where('user_id', $id)->first();
    }

    public function getModuleByTeacherId(int $id)
    {
        return Module::where('id', $this->getTeacherByUserId($id)->module_id)->first();
    }

    public function getMajorByTeacherId(int $id)
    {
        return Major::where('id', $this->getModuleByTeacherId($id)->major_id)->first();
    }

    public function getDepartementByTeacherId(int $id)
    {
        return Department::where('id', $this->getMajorByTeacherId($id)->department_id)->first();
    }

    public function getTeachersByDepartementId(int $id)
    {
        return Teacher::where('module_id', Module::where('major_id', Major::where('departement_id', $id)))->get();
    }
}
