<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Orchid\Access\UserAccess;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class QuestionOption extends Model
{
    use SoftDeletes, HasFactory, Filterable, HasFactory, Notifiable, UserAccess, AsSource;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'question_options';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'name',
        'is_correct',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_correct' => 'boolean',
    ];

    /**
     * Get the question that owns the option.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
