<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\User;
use App\Models\Classe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{

    function generateCNE()
    {
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';

        // Start with a random letter
        $cne = $letters[mt_rand(0, strlen($letters) - 1)];

        // Append 9 random numbers
        for ($i = 0; $i < 9; $i++) {
            $cne .= $numbers[mt_rand(0, strlen($numbers) - 1)];
        }

        return $cne;
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create([
            'role' => Role::STUDENT,
        ]);

        // Get a random class
        $class = Classe::inRandomOrder()->first();

        return [
            'CNE' => $this->generateCNE(),
            'user_id' => $user->id,
            'classe_id' => $class->id,
        ];
    }
}
