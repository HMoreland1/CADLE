<?php

namespace Database\Seeders;

// ContentCategorySeeder.php

use Illuminate\Database\Seeder;

class ContentCategorySeeder extends Seeder
{
    public function run()
    {
        \App\Models\ContentCategory::factory(10)->create();
    }
}
