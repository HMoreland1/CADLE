<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Orchid\Access\UserAccess;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
class Quiz extends Model
{
    use SoftDeletes, HasFactory, Filterable, HasFactory, Notifiable, UserAccess, AsSource;


    protected $table = 'quizzes';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'total_marks',
        'pass_marks',
        'max_attempts',
        'is_published',
        'media_url',
        'media_type',
        'duration',
        'valid_from',
        'valid_upto',
        'time_between_attempts',
    ];

    protected $allowedFilters = [
        'name'          => Like::class,
        'description'        => Like::class,
    ];

    protected $allowedSorts = [
        'id',
        'name',
        'description',
        'updated_at',
        'created_at',
    ];

    protected $dates = ['valid_from', 'valid_upto'];
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'quiz_questions', 'quiz_id', 'question_id');
    }
    public function quizQuestions()
    {
        return $this->hasMany(QuizQuestion::class, 'quiz_id');
    }
}
