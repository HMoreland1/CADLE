<?php

declare(strict_types=1);

namespace App\Orchid\Screens\LearningContent\ContentAssignments\Users;

use App\Models\LearningContent;
use App\Models\UserAssignedContent;
use App\Orchid\Layouts\LearningContent\ContentAssignments\ContentListLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class UserContentAssignmentScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $userId = request('userId');

        $assignedContent = UserAssignedContent::query()
            ->where('user_id', $userId)
            ->pluck('content_id')
            ->toArray();

        return [
            'content' => LearningContent::query()
                ->filters()
                ->defaultSort('content_id', 'desc')
                ->paginate(),
            'assignedContent' => $assignedContent,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'User Management';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all registered users, including their profiles and privileges.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.users',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save'))
                ->icon('bs.plus-circle')
                ->method('saveAssignments'),
        ];

    }

    /**
     * The screen's layout elements.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            ContentListLayout::class
        ];
    }

    /**
     * @return array
     */
    public function asyncGetUser(User $user): iterable
    {
        return [
            'user' => $user,
        ];
    }
    /**
     * Save assignments method.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveAssignments(Request $request)
    {
        // Retrieve user ID and selected content IDs from the request
        $userId = request('userId');
        $selectedContentIds = $request->input('selected_content');

        // Begin a database transaction
        DB::beginTransaction();

        try {
            // Retrieve existing assignments for the user
            $existingAssignments = UserAssignedContent::where('user_id', $userId)->get();

            // Loop through existing assignments
            foreach ($existingAssignments as $existingAssignment) {
                // Check if the content ID exists in the selected content IDs
                if (!in_array($existingAssignment->content_id, $selectedContentIds)) {
                    // Delete the assignment if the content is no longer selected
                    $existingAssignment->delete();
                }
            }

            // Create new assignments for the selected content IDs
            foreach ($selectedContentIds as $contentId) {
                // Check if the assignment already exists
                $existingAssignment = UserAssignedContent::where('user_id', $userId)
                    ->where('content_id', $contentId)
                    ->first();

                // Create new assignment only if it doesn't exist
                if (!$existingAssignment) {
                    UserAssignedContent::create([
                        'user_id' => $userId,
                        'content_id' => $contentId,
                        // You can set other fields like 'importance' and 'completed' here if needed
                    ]);
                }
            }

            // Commit the transaction if everything went well
            DB::commit();

            // Display a success message
            Toast::success('Assignments saved successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurred
            DB::rollback();

            // Log the error
            logger()->error('Error saving assignments: ' . $e->getMessage());

            // Display an error message
            Toast::error('An error occurred while saving assignments. Please try again.');
        }

        // Redirect back to the screen or any other route
        return redirect()->back();
    }




}
