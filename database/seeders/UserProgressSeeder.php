<?php

namespace Database\Seeders;

// UserProgressSeeder.php

use Illuminate\Database\Seeder;

class UserProgressSeeder extends Seeder
{
    public function run()
    {
        \App\Models\UserProgress::factory(10)->create();
    }
}
