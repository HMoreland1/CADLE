<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Orchid\Access\UserAccess;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Pathway extends Model
{

    use  Filterable, HasFactory, Notifiable, UserAccess, AsSource;

    protected $fillable = [
        'name',
        'description',
        'content_ids',
    ];

    protected $casts = [
        'content_ids' => 'array', // Casting content_ids column to array
    ];
}
