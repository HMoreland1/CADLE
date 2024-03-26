<?php

namespace Database\Seeders;

// LearningContentSeeder.php

use Illuminate\Database\Seeder;

class LearningContentSeeder extends Seeder
{
    public function run()
    {
        \App\Models\LearningContent::factory(10)->create();
    }
}

