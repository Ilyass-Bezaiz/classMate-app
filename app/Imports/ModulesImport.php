<?php

namespace App\Imports;

use App\Models\Major;
use App\Models\Module;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ModulesImport implements ToModel, WithHeadingRow, WithValidation
{
    private $filieres;

    public function __construct()
    {
        $this->filieres = Major::select('id', 'name')->get();
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            $filiere = $this->filieres->where('name', $row['nom_filiere'])->first();
            return new Module([
                'name' => $row['nom_module'],
                'major_id' => $filiere->id,
            ]);
        } catch (\Exception $th) {
            throw new \Exception('La filière '. $row['nom_filiere'].' n\'existe pas dans la base de données.');
        }
    }

    public function rules(): array
    {
        return [
            'nom_module' => [
                'required',
                'string',
            ],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nom_module.required' => 'Le nom du module ne peut pas être vide à la cellule :attribute.',
            'nom_module.string' => 'Le nom du module doit être chaine de catactère à la cellule :attribute.',
        ];
    }
}
