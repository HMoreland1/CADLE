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
        $assignedContentIds = UserRoleAssignedContent::where('user_id', $userId)
            ->where('completed', false)
            ->pluck('content_id'); // Get the content IDs

        // Fetch learning content based on the content IDs
        $learningContent = LearningContent::whereIn('id', $assignedContentIds)->get();

        // Remove duplicate records from the learning content
        $learningContent = $this->removeDuplicates($learningContent);

        // Return the learning content as JSON response
        return response()->json($learningContent);
    }

    public function getAssignedContentCompletionStatus($userId)
    {
        try {
            // Fetch learning content IDs assigned directly to the user
            $assignedContent = UserAssignedContent::where('user_id', $userId)->get();
            $roleAssignedContent = UserRoleAssignedContent::where('user_id', $userId)->get();
            // Merge the collections and remove duplicates
            $mergedAssignedContent = $assignedContent->concat($roleAssignedContent)->unique('content_id');


            // Fetch all learning content from the learning_contents table
            $totalLearningContentCount = LearningContent::count();

            // Initialize counters for each category
            $essentialCount = 0;
            $essentialCompletedCount = 0;
            $complianceCount = 0;
            $complianceCompletedCount = 0;

            foreach ($assignedContent as $content) {
                // Increment counters based on the importance and completion status
                switch ($content->importance) {
                    case 'Essential':
                        $essentialCount++;
                        if ($content->completed) {
                            $essentialCompletedCount++;
                        }
                        break;
                    case 'Compliance':
                        $complianceCount++;
                        if ($content->completed) {
                            $complianceCompletedCount++;
                        }
                        break;
                    default:
                        // Handle if importance is not specified or unknown
                        break;
                }
            }

            // Calculate percentages
            // Calculate percentages and round to nearest whole number
            $essentialPercentage = $essentialCount > 0 ? round(($essentialCompletedCount / $essentialCount) * 100) : 0;
            $compliancePercentage = $complianceCount > 0 ? round(($complianceCompletedCount / $complianceCount) * 100) : 0;
            $totalCompletedCount = $essentialCompletedCount + $complianceCompletedCount;
            $developmentPercentage = $totalLearningContentCount > 0 ? round(($totalCompletedCount / $totalLearningContentCount) * 100) : 0;


            // Return the percentages as JSON response
            return response()->json([
                'Essential' => $essentialPercentage,
                'Compliance' => $compliancePercentage,
                'Development' => $developmentPercentage,
                'Test' => $essentialCount
            ]);
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error in getAssignedContentCompletionStatus: ' . $e->getMessage());

            // Return an error response
            return response()->json(['error' => 'An error occurred while processing the request'], 500);
        }
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


