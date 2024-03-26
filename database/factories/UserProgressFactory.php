<?php

namespace Database\Factories;
// database/factories/UserProgressFactory.php

use Illuminate\Database\Eloquent\Factories\Factory;

class UserProgressFactory extends Factory
{
    protected $model = \App\Models\UserProgress::class;

    public function definition()
    {
        return [
            'completed_at' => $this->faker->dateTime,
            'content_id' => \App\Models\LearningContent::factory(),
            'user_id' => \App\Models\User::factory(),
            'score' => $this->faker->numberBetween(0, 100),
        ];
    }
}

