<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
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
        // todo: CNE VALIDATION

        $user = $this->users->where('name', $row['name'])->where('email', $row['email'])->first();

        return new Student([
            'user_id' => $user->id,
            'CNE' => $row['cne'],
        ]);
    }

    public function uniqueBy()
    {
        return 'CNE';
    }

    public function rules(): array
    {
        return [
            // 'CNE' => [
            //     'required',
            //     'string',
            //     'unique:students',
            // ],
        ];
    }

    public function customValidationMessages()
    {
        return [
            // 'CNE.required' => 'Veulliez entrer une CNE à la cellule :attribute.',
            // 'CNE.string' => 'Veulliez entrer une CNE valide à la cellule :attribute.',
        ];
    }
}
