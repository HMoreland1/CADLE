<?php

declare(strict_types=1);

namespace App\Orchid\Screens\LearningContent\ContentAssignments\Roles;

use App\Models\LearningContent;
use App\Models\RoleAssignedContent;
use App\Models\RoleUser;
use App\Models\UserAssignedContent;
use App\Models\UserRoleAssignedContent;
use App\Orchid\Layouts\LearningContent\ContentAssignments\ContentListLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class RoleContentAssignmentScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $roleId = request('roleId');

        $assignedContent = RoleAssignedContent::query()
            ->where('role_id', $roleId)
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
        // Retrieve role ID and selected content IDs from the request
        $roleId = request('roleId');
        $selectedContentIds = $request->input('selected_content');

        // Begin a database transaction
        DB::beginTransaction();

        try {
            // If no content is selected, remove all user assignments for the role and delete the role assignments
            if (empty($selectedContentIds)) {
                UserRoleAssignedContent::where('role_id', $roleId)
                    ->where('completed', 0)
                    ->delete();
                RoleAssignedContent::where('role_id', $roleId)->delete();
            } else {
                // Retrieve existing role assignments for the role
                $existingRoleAssignments = RoleAssignedContent::where('role_id', $roleId)->get();

                // Loop through existing role assignments
                foreach ($existingRoleAssignments as $existingAssignment) {
                    // Check if the content ID exists in the selected content IDs
                    if (!in_array($existingAssignment->content_id, $selectedContentIds)) {
                        // Delete the assignment if the content is no longer selected
                        $existingAssignment->delete();
                    }
                }

                $existingUserRoleAssignedContent = UserRoleAssignedContent::where('role_id', $roleId)
                    ->where('completed', 0)
                    ->get();
                // Loop through existing user role assigned content
                foreach ($existingUserRoleAssignedContent as $existingAssignment) {
                    // Check if the content ID exists in the selected content IDs
                    if (!in_array($existingAssignment->content_id, $selectedContentIds)) {
                        // Delete the assignment if the content is no longer selected
                        UserRoleAssignedContent::where('role_id', $roleId)
                            ->where('completed', 0)
                            ->where('content_id', $existingAssignment->content_id)
                            ->delete();
                    }
                }
                // Iterate over selected content IDs
                foreach ($selectedContentIds as $contentId) {
                    // Check if an assignment already exists for the content and role
                    $existingAssignment = RoleAssignedContent::where('role_id', $roleId)
                        ->where('content_id', $contentId)
                        ->first();

                    // Create new assignment if it doesn't exist
                    if (!$existingAssignment) {
                        RoleAssignedContent::create([
                            'role_id' => $roleId,
                            'content_id' => $contentId,
                            // You can set other fields like 'importance' and 'completed' here if needed
                        ]);
                    }
                }


                // Retrieve user IDs assigned to the role
                $userIds = RoleUser::where('role_id', $roleId)->pluck('user_id');
                // Iterate over each user and create assignments
                foreach ($selectedContentIds as $contentId) {
                    foreach ($userIds as $userId) {
                        // Check if the assignment already exists
                        $existingAssignment = UserRoleAssignedContent::where('role_id', $roleId)
                            ->where('content_id', $contentId)
                            ->where('user_id', $userId)
                            ->first();
                        // Create new assignment only if it doesn't exist
                        if (!$existingAssignment) {
                            UserRoleAssignedContent::create([
                                'role_id' => $roleId,
                                'user_id' => $userId,
                                'content_id' => $contentId,
                                // You can set other fields like 'completed' here if needed
                            ]);
                        }
                    }
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
