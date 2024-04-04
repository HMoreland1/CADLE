<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAssignedContent extends Model
{
    use HasFactory;

    protected $table = 'user_assigned_content';

    protected $fillable = [
        'user_id',
        'learning_content_id',
        'completed',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function learningContent()
    {
        return $this->belongsTo(LearningContent::class);
    }
}
