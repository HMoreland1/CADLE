<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('content_categories', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_categories');
    }
}
