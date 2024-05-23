<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\ExamSeeder;
use Database\Seeders\MajorSeeder;
use Database\Seeders\ClasseSeeder;
use Database\Seeders\ModuleSeeder;
use Database\Seeders\StudentSeeder;
use Database\Seeders\TeacherSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\StudentAbsenceSeeder;
use Database\Seeders\TeacherAbsenceSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            DepartmentSeeder::class,
            MajorSeeder::class,
            ModuleSeeder::class,
            TeacherSeeder::class,
            ClasseSeeder::class,
            ClassTeacherSeeder::class,
            StudentSeeder::class,
            TeacherAbsenceSeeder::class,
            ExamSeeder::class,
            StudentAbsenceSeeder::class,
        ]);
    }
}
