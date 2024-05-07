<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Quiz::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'description' => $this->faker->paragraph,
            'total_marks' => $this->faker->numberBetween(10, 100),
            'pass_marks' => $this->faker->numberBetween(5, 50),
            'max_attempts' => $this->faker->numberBetween(1, 5),
            'is_published' => $this->faker->boolean,
            'media_url' => $this->faker->imageUrl(),
            'media_type' => 'image',
            'duration' => $this->faker->numberBetween(30, 120),
            'valid_from' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'valid_upto' => $this->faker->dateTimeBetween('+1 month', '+6 months'),
            'time_between_attempts' => $this->faker->numberBetween(1, 24),
        ];
    }
}
