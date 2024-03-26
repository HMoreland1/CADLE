<?php

namespace Database\Seeders;

// RoleAssignmentSeeder.php

use Illuminate\Database\Seeder;

class RoleAssignmentSeeder extends Seeder
{
    public function run()
    {
        \App\Models\RoleAssignment::factory(10)->create();
    }
}

