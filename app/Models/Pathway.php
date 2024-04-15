<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Orchid\Access\UserAccess;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Metrics\Chartable;
use Orchid\Platform\Concerns\Sortable;
use Orchid\Screen\AsSource;

class Pathway extends Model
{

    use  Filterable, Chartable, Sortable, HasFactory, AsSource;
    protected $table = 'pathways';

    protected $fillable = [
        'name',
        'description',
        'content_ids',
    ];

    protected $casts = [
        'content_ids' => 'array', // Casting content_ids column to array
    ];


    protected $allowedFilters = [
        'name'              => Like::class,
        'description'       => Like::class,
    ];

    protected $allowedSorts = [
        'name',
        'description',
        'updated_at',
        'created_at',
    ];
}
