<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningContentsTable extends Migration
{
    public function up()
    {
        Schema::create('learning_contents', function (Blueprint $table) {
            $table->id('content_id');
            $table->longText('content');
            $table->longText('description');
            $table->string('title', 100);
            $table->string('image_filename')->nullable(); // Add a new column for storing image filename
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('learning_contents');
    }
}
