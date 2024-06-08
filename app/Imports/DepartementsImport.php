<?php

namespace App\Imports;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DepartementsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Department([
            'name' => $row['nom_department'],
        ]);
    }

    public function rules(): array
    {
        return [
            'nom_department' => [
                'required',
                'string',
            ],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nom_department.required' => 'Le nom du département ne peut pas être vide à la cellule :attribute.',
            'nom_department.string' => 'Le nom du département doit être chaine de catactère à la cellule :attribute.',
        ];
    }
}
