<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $primaryKey = 'quiz_id';

    protected $fillable = [
        'created_by_user_id',
        'description',
        'title',
        'question_ids', // Add this field
    ];

    protected $casts = [
        'question_ids' => 'array', // Cast the field to an array
    ];

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by_user_id', 'id');
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class, 'quiz_id', 'quiz_id');
    }
}  
