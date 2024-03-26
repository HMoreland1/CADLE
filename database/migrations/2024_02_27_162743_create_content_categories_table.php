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
            $table->string('category_name', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('content_categories');
    }
}
