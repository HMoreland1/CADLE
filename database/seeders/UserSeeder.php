<?php

namespace Database\Seeders;

// UserSeeder.php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        \App\Models\User::factory(10)->create();
    }
}
