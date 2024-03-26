<?php

namespace Database\Seeders;

// database/seeders/SanctumSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Database\Seeder;

class SanctumSeeder extends Seeder
{
    public function run()
    {
        // Retrieve all users and create Sanctum tokens for each
        User::all()->each(function (User $user) {
            Sanctum::actingAs($user, ['*']);
        });
    }
}
