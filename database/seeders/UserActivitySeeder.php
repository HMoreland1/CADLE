<?php

namespace Database\Seeders;

// UserActivitySeeder.php

use Illuminate\Database\Seeder;

class UserActivitySeeder extends Seeder
{
    public function run()
    {
        \App\Models\UserActivity::factory(10)->create();
    }
}
