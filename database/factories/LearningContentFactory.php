<?php
// database/factories/LearningContentFactory.php

namespace Database\Factories;

use App\Models\LearningContent;
use Illuminate\Database\Eloquent\Factories\Factory;

class LearningContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LearningContent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => "test description",
            'categories' => ["category 1", "category 2"],
            'content' => "test content",
            'quiz_id' => null, // Update as needed
            'title' => "test content",
        ];
    }
}
