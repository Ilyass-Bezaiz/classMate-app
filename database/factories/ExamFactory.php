<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\Module;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Select a random teacher
        $teacher = Teacher::inRandomOrder()->first();

        // Get the classes that this teacher teaches
        $classes = $teacher->classes; // Assumes a Teacher hasMany relationship with Classe

        // Select a random class from the teacher's classes
        $class = $classes->random();

        // Get the modules that are taught in this class
        $module = $teacher->module; // Assumes modules are linked to classes

        // dd(["mdl=>" . $module->id, "cls=>" . $class->id, "tch=>" . $teacher->id]);
        return [
            'module_id' => $module->id,
            'teacher_id' => $teacher->id,
            'classe_id' => $class->id,
            'date' => $this->faker->dateTimeBetween('+1 week', '+1 year')->format('Y-m-d'),
        ];
    }
}
