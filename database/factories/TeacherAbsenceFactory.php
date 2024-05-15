<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TeacherAbsence>
 */
class TeacherAbsenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get a random teacher
        $teacher = Teacher::inRandomOrder()->first();

        // Generate a random duration (in hours) for the absence (between 1 and 8 hours)
        // $duration = $this->faker->numberBetween(1, 8);

        return [
            'teacher_id' => $teacher->id,
            'from' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'to' => $this->faker->dateTimeBetween('now', '+1 month'),
            // 'duration' => $duration,
        ];
    }
}
