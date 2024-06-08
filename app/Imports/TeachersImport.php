<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Teacher;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TeachersImport implements ToModel, WithHeadingRow, WithValidation, WithUpserts
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
        // todo: CIN VALIDATION
        // $CIN_KEY = 'CIN';
        // $row[$CIN_KEY] = $row['cin'];
        // unset($row['cin']);
        // dd($row);
        $user = $this->users->where('name', $row['nom_complet'])->where('email', $row['email'])->first();

        return new Teacher([
            'diploma' => $row['diplome'],
            'user_id' => $user->id,
            'CIN' => $row['cin'],
        ]);
    }

    public function uniqueBy()
    {
        return 'CIN';
    }

    public function rules(): array
    {
        return [
            'diplome' => [
                'string',
            ],
            // 'CIN' => [
            //     'required',
            //     'string',
            // ],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'diplome.string' => 'Veulliez entrer une diplome valide à la cellule :attribute.',
            'CIN.required' => 'Veulliez entrer une CIN à la cellule :attribute.',
            'CIN.string' => 'Veulliez entrer une CIN valide à la cellule :attribute.',
        ];
    }
}
