<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleLearningAssignment extends Model
{
    protected $table = 'role_learning_assignments';

    protected $fillable = [
        'role_id',
        'learning_content_id',
        'assigned_at',
        // Add other fillable fields as needed
    ];

    // Define relationships if necessary
    public function role()
    {
        return $this->belongsTo(UserRole::class,  'role_id');
    }

    public function learningContent()
    {
        return $this->belongsTo(LearningContent::class, 'content_id');
    }
}
