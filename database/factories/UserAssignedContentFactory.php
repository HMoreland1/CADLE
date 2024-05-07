<?php
namespace Database\Factories;

use App\Models\UserAssignedContent;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAssignedContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserAssignedContent::class;

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
            'content_id' => function () {
                return \App\Models\LearningContent::factory()->create()->id;
            },
            'completed' => $this->faker->boolean,
        ];
    }
}
