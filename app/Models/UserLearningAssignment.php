<?php

namespace App\Models;

use App\Models\LearningContent;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserLearningAssignment extends Model
{
    protected $table = 'user_learning_assignments';

    protected $fillable = [
        'user_id',
        'learning_content_id',
        'assigned_at',
        // Add other fillable fields as needed
    ];

    // Define relationships if necessary
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function learningContent()
    {
        return $this->belongsTo(LearningContent::class, 'content_id');
    }
}
