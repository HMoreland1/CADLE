<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningContentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('learning_contents', function (Blueprint $table) {
            $table->increments('content_id');
            $table->foreignId('quiz_id')->constrained('quizzes', "id");
            $table->json('category_ids')->nullable();
            $table->longText('description');
            $table->longText('content');
            $table->string('title', 100);
            $table->string('image_filename')->nullable();
            $table->timestamps();
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('learning_contents');
    }
}
