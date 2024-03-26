<?php

namespace Database\Seeders;

// database/seeders/AllModelsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AllModelsSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(ContentCategorySeeder::class);
        $this->call(LearningContentSeeder::class);
        $this->call(QuizSeeder::class);
        $this->call(QuizQuestionSeeder::class);
        $this->call(UserActivitySeeder::class);
        $this->call(UserProgressSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(UserSessionSeeder::class);
        $this->call(RoleAssignmentSeeder::class);
        // Set up Sanctum for seeded users
        $this->call(SanctumSeeder::class);
    }
}
