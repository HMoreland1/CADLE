<?php
// app/Http/Controllers/LearningContentController.php

namespace App\Http\Controllers;

use App\Models\LearningContent;
use Illuminate\Http\Request;

class LearningContentController extends Controller
{
    public function getAllContent()
    {
        // Fetch all learning content
        $learningContent = LearningContent::all();

        // Return the learning content as JSON response
        return response()->json($learningContent);
    }
}
