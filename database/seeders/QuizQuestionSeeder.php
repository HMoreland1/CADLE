<?php

namespace Database\Seeders;

// QuizQuestionSeeder.php

use Illuminate\Database\Seeder;

class QuizQuestionSeeder extends Seeder
{
    public function run()
    {
        \App\Models\QuizQuestion::factory(10)->create();
    }
}

