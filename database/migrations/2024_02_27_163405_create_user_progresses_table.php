<?php
// Adjust the timestamps, columns, and constraints as needed

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProgressesTable extends Migration
{
    public function up()
    {
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id('progress_id');
            $table->dateTime('completed_at');
            $table->unsignedBigInteger('content_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('score');

            $table->foreign('content_id')->references('content_id')->on('learning_contents');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_progresses');
    }
}

