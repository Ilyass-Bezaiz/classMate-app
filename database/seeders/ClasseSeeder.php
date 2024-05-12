<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\Classe;
use App\Models\Module;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            'Génie Logiciel' => [
                ['name' => 'GL1', 'school_year' => 2023],
                ['name' => 'GL2', 'school_year' => 2023],
                ['name' => 'GL3', 'school_year' => 2023]
            ],
            'Intelligence Artificielle' => [
                ['name' => 'IA1', 'school_year' => 2023],
                ['name' => 'IA2', 'school_year' => 2023],
                ['name' => 'IA3', 'school_year' => 2023]
            ],
            'Physique' => [
                ['name' => 'PHY1', 'school_year' => 2023],
                ['name' => 'PHY2', 'school_year' => 2024],
                ['name' => 'PHY3', 'school_year' => 2025]
            ],
            'Chimie' => [
                ['name' => 'CHM1', 'school_year' => 2023],
                ['name' => 'CHM2', 'school_year' => 2024],
                ['name' => 'CHM3', 'school_year' => 2025]
            ],
            'Comptabilité' => [
                ['name' => 'CPT1', 'school_year' => 2023],
                ['name' => 'CPT2', 'school_year' => 2024],
                ['name' => 'CPT3', 'school_year' => 2025]
            ],
            'Marketing' => [
                ['name' => 'MKT1', 'school_year' => 2023],
                ['name' => 'MKT2', 'school_year' => 2024],
                ['name' => 'MKT3', 'school_year' => 2025]
            ],
            'Littérature' => [
                ['name' => 'LIT1', 'school_year' => 2023],
                ['name' => 'LIT2', 'school_year' => 2024],
                ['name' => 'LIT3', 'school_year' => 2025]
            ],
            'Linguistique' => [
                ['name' => 'LIN1', 'school_year' => 2023],
                ['name' => 'LIN2', 'school_year' => 2024],
                ['name' => 'LIN3', 'school_year' => 2025]
            ],
            'Droit Public' => [
                ['name' => 'DPU1', 'school_year' => 2023],
                ['name' => 'DPU2', 'school_year' => 2024],
                ['name' => 'DPU3', 'school_year' => 2025]
            ],
            'Droit Privé' => [
                ['name' => 'DPR1', 'school_year' => 2023],
                ['name' => 'DPR2', 'school_year' => 2024],
                ['name' => 'DPR3', 'school_year' => 2025]
            ]
        ];

        foreach ($classes as $majorName => $classData) {
            $major = Major::where('name', $majorName)->first();
            foreach ($classData as $class) {

                Classe::create([
                    'major_id' => $major->id,
                    'name' => $class['name'],
                    'school_year' => $class['school_year'],
                ]);
            }
        }

        // ------------ version of inserting  teacher_id ------------
        // foreach ($classes as $majorName => $classData) {
        //     $major = Major::where('name', $majorName)->first();
        //     foreach ($classData as $class) {
        //         $module = Module::where('major_id', $major->id)->inRandomOrder()->first();
        //         $teacher = Teacher::where('module_id', $module->id)->inRandomOrder()->first();

        //         Classe::create([
        //             'name' => $class['name'],
        //             'major_id' => $major->id,
        //             'teacher_id' => $teacher->id,
        //             'year' => $class['year'],
        //         ]);
        //     }
        // }
    }
}
