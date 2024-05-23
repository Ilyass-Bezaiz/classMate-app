<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all teachers
        $teachers = Teacher::with('module')->get();
        // dd($teachers[0]->module->major->id);
        foreach ($teachers as $teacher) {
            // Fetch classes that belong to the same major as the teacher
            $classes = Classe::where('major_id', $teacher->module->major->id)->get();

            // If there are classes that match the teacher's major
            if ($classes->isNotEmpty()) {
                // Pick 2-5 random classes from the list
                $randomClasses = $classes->random(rand(2, 3));

                foreach ($randomClasses as $class) {
                    // Insert the teacher-class association into the pivot table
                    DB::table('class_teachers')->insert([
                        'teacher_id' => $teacher->id,
                        'classe_id' => $class->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
