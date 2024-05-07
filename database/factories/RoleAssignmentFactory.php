<?php
// database/factories/RoleAssignmentFactory.php

namespace Database\Factories;

use App\Models\RoleAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleAssignmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RoleAssignment::class;

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
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
        ];
    }
}
