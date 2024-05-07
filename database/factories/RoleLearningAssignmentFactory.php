<?php
// database/factories/RoleLearningAssignmentFactory.php

namespace Database\Factories;

use App\Models\RoleLearningAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleLearningAssignmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RoleLearningAssignment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'role_id' => function () {
                return \App\Models\Role::factory()->create()->id;
            },
            'learning_content_id' => function () {
                return \App\Models\LearningContent::factory()->create()->id;
            },
            'assigned_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
