<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class ContentCategory extends Model
{
    use HasFactory, AsSource;

    protected $primaryKey = 'category_id';
    protected $fillable = ['category_name'];

    public $timestamps = true;

    // Define relationships or additional methods as needed
}
