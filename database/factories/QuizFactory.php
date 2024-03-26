<?php

namespace Database\Factories;
// QuizFactory.php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    public function definition()
    {
        return [
            'created_by_user_id' => function () {
                return \App\Models\User::factory()->create()->user_id;
            },
            'description' => $this->faker->paragraph,
            'title' => $this->faker->sentence,
            'question_ids' => [], // Initialize the field as an empty array
        ];
    }
}
