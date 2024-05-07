<?php
// database/factories/UserLearningAssignmentFactory.php

namespace Database\Factories;

use App\Models\UserLearningAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserLearningAssignmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserLearningAssignment::class;

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
            'learning_content_id' => function () {
                return \App\Models\LearningContent::factory()->create()->id;
            },
            'assigned_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
