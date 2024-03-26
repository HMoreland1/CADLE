<?php

namespace Database\Factories;
// database/factories/QuizQuestionFactory.php

use Illuminate\Database\Eloquent\Factories\Factory;

class QuizQuestionFactory extends Factory
{
    protected $model = \App\Models\QuizQuestion::class;

    public function definition()
    {
        return [
            'question_text' => $this->faker->sentence,
            'option_1' => $this->faker->word,
            'option_2' => $this->faker->word,
            'option_3' => $this->faker->word,
            'option_4' => $this->faker->word,
            'correct_option' => $this->faker->randomElement([1, 2, 3, 4]),
        ];
    }
}
