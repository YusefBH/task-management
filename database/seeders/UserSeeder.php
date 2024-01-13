<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 20; $i++) {
            User::create([
                'name' => fake()->name(),
                'email' => fake()->email,
                'password' => Hash::make('12345678'),
            ]);
        }
        User::create([
            "id" => 100,
            "name" => "yousef",
            "email" => "yusefbh1382@gamil.com",
            "password" => Hash::make('12345678'),
        ]);

    }
}
