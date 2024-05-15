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

        // Get the major of the class
        $major = $class->major;

        // Get all teachers associated with the modules of the major
        $teachers = collect();
        foreach ($major->modules as $module) {
            $teachers = $teachers->merge($module->teachers);
        }

        // Randomly select a teacher from the collection
        $teacher = $teachers->random();


        // Generate a random date within the last 6 months
        $date = $this->faker->dateTimeBetween('-6 months', 'now');

        // Generate a random hour for the time column
        $startHour = $this->faker->randomElement([8, 9, 10, 11, 14, 15, 16, 17]); // Random hour from the specified ranges
        $endHour = $startHour + 1; // End hour is one hour later than start hour
        $time = "{$startHour}-{$endHour}"; // Format the time interval

        return [
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'date' => $date,
            'time' => $time,
        ];
    }
}
