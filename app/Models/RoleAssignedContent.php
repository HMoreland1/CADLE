<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleAssignedContent extends Model
{
    use HasFactory;

    protected $table = 'role_assigned_content';


    protected $fillable = [
        'role_id',
        'content_id', // Updated field name
        'importance', // New field
        'completed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function learningContent()
    {
        return $this->belongsTo(LearningContent::class);
    }
}
