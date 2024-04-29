<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoleAssignedContentTable extends Migration
{
    public function up()
    {
        Schema::create('user_role_assigned_content', function (Blueprint $table) {
            // Define id column as primary key
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('content_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('content_id')
                ->references('content_id')
                ->on('learning_contents')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            // Define foreign key constraint for content_id column, specifying the column name
            $table->enum('importance', ['Essential', 'Compliance'])->default('Essential');
            // Define completed column with default value of false
            $table->boolean('completed')->default(false);

            // Define timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_role_assigned_content');
    }
}
