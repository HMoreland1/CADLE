<?php

namespace Database\Seeders;

// DatabaseSeeder.php

use Illuminate\Database\Seeder;
use Laravel\Sanctum\Sanctum;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed all models
        $this->call(AllModelsSeeder::class);

        // Set up Sanctum for seeded users
    }
}
