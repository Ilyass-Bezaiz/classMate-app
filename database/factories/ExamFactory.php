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
        // Get a random module
        $module = Module::inRandomOrder()->first();

        // Get the module's major
        $major = $module->major;

        // Get a random class associated with the major
        $class = Classe::where("major_id", $major->id)->inRandomOrder()->first();

        // Get teachers associated with the selected module
        $teachers = $module->teachers;
        $teacher = $teachers->random();

        // Generate a random date within the next 6 months
        $date = $this->faker->dateTimeBetween('now', '+6 months');

        return [
            'module_id' => $module->id,
            'teacher_id' => $teacher->id,
            'classe_id' => $class->id,
            'date' => $date,
        ];
    }
}
