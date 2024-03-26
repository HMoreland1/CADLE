<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserRole;

class UserRoleFactory extends Factory
{
    protected $model = UserRole::class;

    public function definition()
    {
        return [
            'role_name' => $this->faker->word,
        ];
    }
}

