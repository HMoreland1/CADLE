<?php

// Adjust the timestamps, columns, and constraints as needed

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleAssignmentsTable extends Migration
{
    public function up()
    {
        Schema::create('role_assignments', function (Blueprint $table) {
            $table->id('assignment_id');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('role_id')->references('role_id')->on('user_roles');
            $table->foreign('user_id')->references('id')->on('users');

            // Remove the following lines if you don't need timestamp columns
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('role_assignments');
    }
}
