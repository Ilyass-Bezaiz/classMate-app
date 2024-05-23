<?php

namespace Database\Seeders;

use App\Models\StudentAbsence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentAbsenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudentAbsence::factory()->count(15)->create();
    }
}
