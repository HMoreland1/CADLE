<?php

namespace Database\Factories;
// database/factories/UserActivityFactory.php

use Illuminate\Database\Eloquent\Factories\Factory;

class UserActivityFactory extends Factory
{
    protected $model = \App\Models\UserActivity::class;

    public function definition()
    {
        return [
            'activity_timestamp' => $this->faker->dateTime,
            'activity_type' => $this->faker->word,
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
