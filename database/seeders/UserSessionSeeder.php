<?php

namespace Database\Seeders;

// UserSessionSeeder.php

use Illuminate\Database\Seeder;

class UserSessionSeeder extends Seeder
{
    public function run()
    {
        \App\Models\UserSession::factory(10)->create();
    }
}
