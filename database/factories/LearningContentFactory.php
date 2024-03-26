<?php

namespace Database\Factories;
// database/factories/LearningContentFactory.php

use Illuminate\Database\Eloquent\Factories\Factory;

class LearningContentFactory extends Factory
{
    protected $model = \App\Models\LearningContent::class;

    public function definition()
    {
        return [
            'category_id' => \App\Models\ContentCategory::factory(),
            'content' => $this->faker->text,
            'created_by_user_id' => \App\Models\User::factory(),
            'description' => $this->faker->paragraph,
            'title' => $this->faker->sentence,
        ];
    }
}

