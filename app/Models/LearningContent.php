<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class LearningContent extends Model
{
    use AsSource, HasFactory, Filterable, Chartable;

    protected $table = 'learning_contents';
    protected $primaryKey = 'content_id';
    protected $fillable = [
        'content',
        'description',
        'title',
        'image_filename', // Add new field for image path
    ];

    public function userAssignments()
    {
        return $this->hasMany(UserLearningAssignment::class);
    }
}


