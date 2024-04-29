<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAssignedContentTable extends Migration
{
    public function up()
    {
        Schema::create('user_assigned_content', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('content_id');
            $table->foreign('content_id')
                ->references('content_id')
                ->on('learning_contents')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            // Define foreign key constraint for content_id column, specifying the co
            $table->enum('importance', ['Essential', 'Compliance'])->default('Essential');
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_assigned_content');
    }
}
