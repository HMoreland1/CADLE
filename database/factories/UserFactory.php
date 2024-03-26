<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class
UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'password_hash' => bcrypt('password'), // You may want to adjust this
            'forename' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }
}
