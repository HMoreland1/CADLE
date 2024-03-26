<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';
    protected $fillable = ['category_name'];

    public $timestamps = true;

    // Define relationships or additional methods as needed
}
