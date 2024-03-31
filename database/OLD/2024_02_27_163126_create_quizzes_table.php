<?php

// Adjust the timestamps, columns, and constraints as needed

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id('quiz_id');
            $table->unsignedBigInteger('created_by_user_id');
            $table->longText('description');
            $table->string('title', 100);
            $table->timestamps();

            // Add a JSON column to store an array of question IDs
            $table->json('question_ids')->nullable();

            $table->foreign('created_by_user_id')->references('id')->on('users');
        });
    }


    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
}
