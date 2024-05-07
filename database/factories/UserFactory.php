<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class
UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $salt = Str::random(16);
        $forename = $this->faker->firstName;
        $surname = $this->faker->lastName;
        return [
            'email' => $this->faker->unique()->safeEmail,
            'salt' => $salt,
            'password' => Hash::make('password'. env('PEPPER') . $salt ), // You may want to adjust this
            'forename' => $forename,
            'surname' => $surname,
            'name' => $forename . " " . $surname,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }
}

