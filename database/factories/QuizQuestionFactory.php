<?php
// database/factories/QuizQuestionFactory.php

namespace Database\Factories;

use App\Models\QuizQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizQuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuizQuestion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quiz_id' => function () {
                return \App\Models\Quiz::factory()->create()->id;
            },
            'question_id' => function () {
                return \App\Models\Question::factory()->create()->id;
            },
            'marks' => 1,
            'negative_marks' => 1,
            'is_optional' => false,
            'order' => 1,
        ];
    }
}
