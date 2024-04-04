<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoleAssignedContent extends Model
{
    use HasFactory;
    protected $table = 'user_role_assigned_content';

    protected $fillable = [
        'user_id',
        'role_id',
        'learning_content_id',
        'completed',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function learningContent()
    {
        return $this->belongsTo(LearningContent::class);
    }

    // Define relationships here if necessary
}
