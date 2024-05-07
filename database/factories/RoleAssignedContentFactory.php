<?php
// database/factories/RoleAssignedContentFactory.php

namespace Database\Factories;

use App\Models\RoleAssignedContent;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleAssignedContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RoleAssignedContent::class;

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
            'content_id' => function () {
                return \App\Models\LearningContent::factory()->create()->id;
            },
            'completed' => $this->faker->boolean,
        ];
    }
}
