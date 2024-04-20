<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizQuestion extends Model
{
    use SoftDeletes;

    protected $table = 'quiz_questions';

    protected $fillable = [
        'quiz_id',
        'question_id',
        'marks',
        'negative_marks',
        'is_optional',
        'order',
    ];

    // Define relationships and other methods as needed
}
