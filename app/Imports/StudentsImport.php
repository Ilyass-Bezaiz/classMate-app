<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    private $users;

    public function __construct()
    {
        $this->users = User::select('id', 'name', 'email')->get();
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = $this->users->where('name', $row['name'])->where('email', $row['email'])->first();

        return new Student([
            'user_id' => $user->id,
            'CNE' => $row['cne'],
        ]);
    }
}
