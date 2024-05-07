<?php
// database/factories/AuthLogFactory.php

namespace Database\Factories;

use App\Models\AuthLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AuthLog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'ip_address' => $this->faker->ipv4,
            'user_agent' => $this->faker->userAgent,
            'login_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'logout_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'type' => $this->faker->randomElement(['login', 'logout']),
        ];
    }
}
