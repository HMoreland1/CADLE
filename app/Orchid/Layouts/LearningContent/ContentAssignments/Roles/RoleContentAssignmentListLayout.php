<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\LearningContent\ContentAssignments\Roles;

use App\Models\Role;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class RoleContentAssignmentListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'roles';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Role $role) {
                    return Link::make(__('Assign Content'))
                        ->icon('bs.file-plus')
                        ->route('platform.systems.role.learningcontent.assign', ['roleId' => $role->id]);
                }),
            TD::make('name', __('Name'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),



        ];
    }
}
