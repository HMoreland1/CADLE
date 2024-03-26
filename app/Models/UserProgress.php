<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    use HasFactory;
    protected $primaryKey = 'progress_id';

    protected $fillable = [
        'completed_at',
        'content_id',
        'user_id',
        'score',
    ];

    public function learningContent()
    {
        return $this->belongsTo(LearningContent::class, 'content_id', 'content_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
