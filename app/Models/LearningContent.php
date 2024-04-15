<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Metrics\Chartable;
use Orchid\Platform\Concerns\Sortable;
use Orchid\Screen\AsSource;

class LearningContent extends Model
{
    use  Filterable, Chartable, Sortable, HasFactory, AsSource;

    protected $table = 'learning_contents';
    protected $primaryKey = 'content_id';

    protected $fillable = [
        'page_id',
        'description',
        'categories',
        'content',
        'title',
        'image_filename', // Add new field for image path
    ];


    protected $allowedFilters = [
        'title'            => Like::class,
        'description'      => Like::class,
        'categories'       => Like::class,
    ];

    protected $allowedSorts = [
        'name',
        'description',
        'categories',
        'updated_at',
        'created_at',
    ];
    public function userAssignments()
    {
        return $this->hasMany(UserLearningAssignment::class);
    }
}
