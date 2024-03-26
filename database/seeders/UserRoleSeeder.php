<?php

namespace Database\Seeders;

// UserRoleSeeder.php

use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    public function run()
    {
        \App\Models\UserRole::factory(10)->create();
    }
}
