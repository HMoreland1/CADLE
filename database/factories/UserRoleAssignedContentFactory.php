<?php
// database/factories/UserRoleAssignedContentFactory.php

namespace Database\Factories;

use App\Models\UserRoleAssignedContent;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserRoleAssignedContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserRoleAssignedContent::class;

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
            'role_id' => function () {
                return \App\Models\Role::factory()->create()->id;
            },
            'content_id' => function () {
                return \App\Models\LearningContent::factory()->create()->id;
            },
            'completed' => $this->faker->boolean,
        ];
    }
}