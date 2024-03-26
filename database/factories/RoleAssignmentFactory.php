<?php

namespace Database\Factories;
// database/factories/RoleAssignmentFactory.php

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleAssignmentFactory extends Factory
{
    protected $model = \App\Models\RoleAssignment::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'role_id' => $this->faker->randomElement([1, 2, 3]), // Adjust role IDs as needed
        ];
    }
}
