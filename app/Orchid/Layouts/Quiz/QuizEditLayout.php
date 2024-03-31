<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Quiz;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class QuizEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('quiz.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Quiz Name'))
                ->placeholder(__('Enter quiz name')),

            TextArea::make('quiz.description')
                ->rows(3)
                ->title(__('Description'))
                ->placeholder(__('Enter quiz description')),

            Input::make('quiz.total_marks')
                ->type('number')
                ->min(0)
                ->required()
                ->title(__('Total Marks'))
                ->placeholder(__('Enter total marks')),

            Input::make('quiz.pass_marks')
                ->type('number')
                ->min(0)
                ->required()
                ->title(__('Passing Marks'))
                ->placeholder(__('Enter passing marks')),

            Input::make('quiz.max_attempts')
                ->type('number')
                ->min(1)
                ->required()
                ->title(__('Max Attempts'))
                ->placeholder(__('Enter maximum attempts allowed')),

            Input::make('quiz.slug') // Add the slug field
            ->type('text')
                ->required()
                ->title(__('Slug'))
                ->placeholder(__('Enter quiz slug')), // Placeholder can be adjusted as needed

            // Add more fields as needed for other quiz details
        ];
    }
}

