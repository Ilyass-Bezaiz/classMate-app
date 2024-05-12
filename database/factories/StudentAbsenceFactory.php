<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentAbsence>
 */
class StudentAbsenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get a random student
        $student = Student::inRandomOrder()->first();

        // Get a random teacher
        $teacher = Teacher::inRandomOrder()->first();

        // Generate a random date within the last 6 months
        $date = $this->faker->dateTimeBetween('-6 months', 'now');

        return [
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'date' => $date,
        ];
    }
}
