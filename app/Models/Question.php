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
class Question extends Model
{
    use SoftDeletes, HasFactory, Filterable, HasFactory, Notifiable, UserAccess, AsSource;


    protected $table = 'questions';

    protected $fillable = [
        'name',
        'question_type_id',
        'media_url',
        'media_type',
        'is_active',
    ];

    protected $allowedFilters = [
        'name'                   => Like::class,
        'question_type_id'       => Like::class,
    ];

    protected $allowedSorts = [
        'id',
        'name',
        'question_type_id',
        'updated_at',
        'created_at',
    ];

    protected $dates = [
        'valid_from',
        'valid_upto',
        'updated_at',
        'created_at',];
}
