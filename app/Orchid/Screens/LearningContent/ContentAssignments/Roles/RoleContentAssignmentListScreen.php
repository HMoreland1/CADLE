<?php

declare(strict_types=1);

namespace App\Orchid\Screens\LearningContent\ContentAssignments\Roles;

use App\Models\Role;
use App\Orchid\Layouts\LearningContent\ContentAssignments\Roles\RoleContentAssignmentListLayout;
use App\Orchid\Layouts\LearningContent\ContentAssignments\Users\UserContentAssignmentListLayout;
use App\Orchid\Layouts\User\UserEditLayout;
use App\Orchid\Layouts\User\UserFiltersLayout;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class RoleContentAssignmentListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'roles' => Role::filters()
                ->defaultSort('id', 'desc')
                ->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Role Content Assignment';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Assign learning content to all users with a given role.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.roles',
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
            RoleContentAssignmentListLayout::class
        ];
    }

    /**
     * @return array
     */

}
