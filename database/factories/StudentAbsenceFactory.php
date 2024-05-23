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

        // Get the class of the student
        $class = $student->classe;

        // Get the teachers associated with this class
        $teachers = $class->teachers;

        // Randomly select a teacher from the collection
        $teacher = $teachers->random();

        // Generate a random date within the last 6 months
        $date = $this->faker->dateTimeBetween('-6 months', 'now');

        // Random date and time for the absence
        $date = $this->faker->dateTimeBetween('-1 year', 'now');
        $times = ['8-9', '9-10', '10-11', '11-12', '14-15', '15-16', '16-17', '17-18'];
        $time = $this->faker->randomElement($times);
        // dd($teacher->id, $student->id, $time,  $date->format('Y-m-d'));
        return [
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'date' => $date->format('Y-m-d'),
            'time' => $time,
        ];
    }
}
