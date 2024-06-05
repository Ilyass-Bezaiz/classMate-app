<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use App\Models\Administrator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(10)->create();

        $user = User::create([
            'name' => 'Abderrahim Elinaji',
            'email' => 'abderrahim@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '0624242424',
            'role' => Role::ADMIN,
        ]);

        Administrator::create([
            'user_id' => $user->id,
            'access_code' => "1323",
            'CIN' => 'GA242862'
        ]);

    }
}
