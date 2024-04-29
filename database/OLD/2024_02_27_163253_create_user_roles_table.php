<?php

// Adjust the timestamps, columns, and constraints as needed

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRolesTable extends Migration
{
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id('role_id');
            $table->string('role_name', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
}
