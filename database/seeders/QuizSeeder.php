<?php

namespace Database\Seeders;

// QuizSeeder.php

use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Quiz::factory(10)->create();
    }
}
