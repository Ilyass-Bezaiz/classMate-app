<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Informatique',
            'Sciences',
            'Économie et Gestion',
            'Lettres',
            'Science Juridique',
        ];

        foreach ($departments as $departmentName) {
            Department::create(['name' => $departmentName]);
        }
    }
}
