<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use App\Livewire\AdminDashboard\UploadData;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, WithUpserts
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name'     => $row['nom_complet'],
            'email'    => $row['email'],
            'password' => Hash::make($row['password']),
            'role' => UploadData::$UserRole,
        ]);
    }

    public function uniqueBy()
    {
        return 'email';
    }

    public function rules(): array
    {
        return [
            'nom_complet' => [
                'required',
                'string',
            ],
            'email' => [
                'required',
                'email',
            ],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nom_complet.required' => 'Veulliez entrer un nom à la cellule :attribute.',
            'nom_complet.string' => 'Veulliez entrer une nom valide à la cellule :attribute.',
            'email.required' => 'Veulliez entrer une adresse email à la cellule :attribute.',
            'email.email' => 'Veulliez entrer une adresse email valide à la cellule :attribute.',
        ];
    }
}
