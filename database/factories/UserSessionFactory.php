<?php

namespace Database\Factories;
// database/factories/UserSessionFactory.php

use Illuminate\Database\Eloquent\Factories\Factory;

class UserSessionFactory extends Factory
{
    protected $model = \App\Models\UserSession::class;

    public function definition()
    {
        return [
            'ip_address' => $this->faker->ipv4,
            'login_time' => $this->faker->dateTime,
            'session_token' => $this->faker->sha256,
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
