<?php
// database/factories/QuestionFactory.php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'question_type_id' => $this->faker->randomDigitNotNull,
            'media_url' => $this->faker->url,
            'media_type' => $this->faker->randomElement(['image', 'video', 'audio']),
            'is_active' => $this->faker->boolean,
        ];
    }
}
