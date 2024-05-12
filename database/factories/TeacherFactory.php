<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{

    function generateCNI()
    {
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';

        $cni = $letters[mt_rand(0, strlen($letters) - 1)];
        $cni .= $letters[mt_rand(0, strlen($letters) - 1)];
        for ($i = 0; $i < 4; $i++) {
            $cni .= $numbers[mt_rand(0, strlen($numbers) - 1)];
        }

        return $cni;
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create([
            'role' => Role::TEACHER,
        ]);
        $module = Module::inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'module_id' => $module->id,
            'CIN' => $this->generateCNI(),
        ];
    }
}
