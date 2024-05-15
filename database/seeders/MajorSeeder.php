<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = [
            'Informatique' => ['Génie Logiciel', 'Intelligence Artificielle'],
            'Sciences' => ['Physique', 'Chimie'],
            'Économie et Gestion' => ['Comptabilité', 'Marketing'],
            'Lettres' => ['Littérature', 'Linguistique'],
            'Science Juridique' => ['Droit Public', 'Droit Privé'],
        ];

        foreach ($majors as $departmentName => $majorNames) {
            $department = Department::where('name', $departmentName)->first();
            foreach ($majorNames as $majorName) {
                Major::create([
                    'department_id' => $department->id,
                    'name' => $majorName,
                ]);
            }
        }
    }
}
