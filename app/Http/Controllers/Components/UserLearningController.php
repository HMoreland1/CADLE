<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;
use App\Models\LearningContent;
use App\Models\UserAssignedContent;
use App\Models\UserRoleAssignedContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserLearningController extends Controller
{
    public function getAssignedContentForUser($userId)
    {
        // Fetch learning content IDs assigned directly to the user
        $assignedContentIds = UserAssignedContent::where('user_id', $userId)
            ->where('completed', false)
            ->pluck('content_id'); // Get the content IDs

        // Fetch learning content based on the content IDs
        $learningContent = LearningContent::whereIn('content_id', $assignedContentIds)->get();

        // Remove duplicate records from the learning content
        $learningContent = $this->removeDuplicates($learningContent);

        // Return the learning content as JSON response
        return response()->json($learningContent);
    }

    public function getAssignedContentForUserRole($userId)
    {
        // Fetch learning content IDs assigned to the user through their roles
        $assignedContentIds = UserRoleAssignedContent::where('content_id', $userId)
            ->where('completed', false)
            ->pluck('content_id'); // Get the content IDs

        // Fetch learning content based on the content IDs
        $learningContent = LearningContent::whereIn('id', $assignedContentIds)->get();

        // Remove duplicate records from the learning content
        $learningContent = $this->removeDuplicates($learningContent);

        // Return the learning content as JSON response
        return response()->json($learningContent);
    }

    // Function to remove duplicate records from a collection
    private function removeDuplicates($collection)
    {
        $uniqueContent = [];

        foreach ($collection as $content) {
            // Check if the content ID already exists in the unique content array
            if (!in_array($content->id, array_column($uniqueContent, 'id'))) {
                $uniqueContent[] = $content;
            }
        }

        return $uniqueContent;
    }
}


