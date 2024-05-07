<?php
// database/factories/PathwayFactory.php

namespace Database\Factories;

use App\Models\Pathway;
use Illuminate\Database\Eloquent\Factories\Factory;

class PathwayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pathway::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'content_ids' => [], // Update as needed
        ];
    }
}
