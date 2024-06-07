<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Teacher;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeachersImport implements ToModel, WithHeadingRow
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
        // dd($row);
        $user = $this->users->where('name', $row['name'])->where('email', $row['email'])->first();

        return new Teacher([
            'diploma' => $row['diploma'],
            'user_id' => $user->id,
            'CIN' => $row['cin'],
        ]);
    }
}
