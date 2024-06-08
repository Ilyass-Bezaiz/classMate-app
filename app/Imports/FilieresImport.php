<?php

namespace App\Imports;

use App\Models\Major;
use App\Models\Department;
use Masmerise\Toaster\Toaster;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class FilieresImport implements ToModel, WithHeadingRow, WithValidation
{
    private $departements;

    public function __construct()
    {
        $this->departements = Department::select('id', 'name')->get();
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            $departement = $this->departements->where('name', $row['nom_departement'])->firstOrFail();
            return new Major([
                'name' => $row['nom_filiere'],
                'department_id' => $departement->id,
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Le département '. $row['nom_departement'].' n\'existe pas dans la base de données.');
        }
    }

    public function rules(): array
    {
        return [
            'nom_filiere' => [
                'required',
                'string',
            ],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nom_filiere.required' => 'Le nom du filière ne peut pas être vide à la cellule :attribute.',
            'nom_filiere.string' => 'Le nom du filière doit être chaine de catactère à la cellule :attribute.',
        ];
    }
}
