<?php
// app/Http/Controllers/LearningContentController.php

namespace App\Http\Controllers;

use App\Models\LearningContent;
use App\Models\Pathway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class LearningContentController extends Controller
{
    public function getAllContent()
    {
        // Fetch all learning content
        $learningContent = LearningContent::all();

        // Return the learning content as JSON response
        return response()->json($learningContent);
    }

    public function getPathwayContent($pathwayId)
    {
        try {
            // Assuming 'content_ids' is the column name in your Pathway model
            $pathway = Pathway::findOrFail($pathwayId);
            $assignedContentIds = $pathway->content_ids;

            if ($assignedContentIds !== null) {
                // Fetch learning content based on the assigned content IDs
                $content = LearningContent::whereIn('content_id', $assignedContentIds)->get();

                return response()->json($content, 200);
            } else {
                return response()->json([], 200);
            }
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
