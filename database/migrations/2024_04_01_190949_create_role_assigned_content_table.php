<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleAssignedContentTable extends Migration
{
    public function up()
    {
        Schema::create('role_assigned_content', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('role_id');
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedInteger('content_id');

            $table->foreign('content_id')
                ->references('content_id')
                ->on('learning_contents')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->enum('importance', ['Essential', 'Compliance'])->default('Essential');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('role_assigned_content');
    }
}
