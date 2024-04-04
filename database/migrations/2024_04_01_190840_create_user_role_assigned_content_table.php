<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoleAssignedContentTable extends Migration
{
    public function up()
    {
        Schema::create('user_role_assigned_content', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_role_id')->constrained('user_roles', 'role_id')->onDelete('cascade'); // Use role_id as the referenced column
            $table->foreignId('content_id')->constrained('learning_contents', 'content_id')->onDelete('cascade'); // Specify the column name
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_role_assigned_content');
    }
}

