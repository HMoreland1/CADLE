<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class LearningContent extends Model
{
    use HasFactory, AsSource;

    protected $table = 'learning_contents';
    protected $primaryKey = 'content_id';
    protected $fillable = [
        'page_id',
        'description',
        'title',
        'image_filename', // Add new field for image path
    ];

    public function userAssignments()
    {
        return $this->hasMany(UserLearningAssignment::class);
    }
}
