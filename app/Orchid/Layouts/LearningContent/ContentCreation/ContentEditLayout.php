<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\LearningContent\ContentCreation;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class ContentEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('content.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('content.description')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Description'))
                ->placeholder(__('Description')),

        ];
    }
}
