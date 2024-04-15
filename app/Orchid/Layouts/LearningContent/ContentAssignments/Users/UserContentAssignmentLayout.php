<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\LearningContent\ContentAssignments\Users;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class UserContentAssignmentLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('user.forename')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('First Name'))
                ->placeholder(__('First Name')),

            Input::make('user.surname')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Surname'))
                ->placeholder(__('Surname')),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),
        ];
    }
}
