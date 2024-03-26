<?php

namespace Database\Factories;

// database/factories/ContentCategoryFactory.php

use Illuminate\Database\Eloquent\Factories\Factory;

class ContentCategoryFactory extends Factory
{
    protected $model = \App\Models\ContentCategory::class;

    public function definition()
    {
        return [
            'category_name' => $this->faker->word,
        ];
    }
}
