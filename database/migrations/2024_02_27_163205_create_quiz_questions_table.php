<?php

// Adjust the timestamps, columns, and constraints as needed

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id('question_id');
            $table->longText('question_text');
            $table->longText('option_1')->nullable();
            $table->longText('option_2')->nullable();
            $table->longText('option_3')->nullable();
            $table->longText('option_4')->nullable();
            $table->unsignedBigInteger('correct_option')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_questions');
    }
}
