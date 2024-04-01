<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Quiz;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class QuestionEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('question.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Question'))
                ->placeholder(__('Enter the question')),

            Select::make('question.question_type_id')
                ->options([
                    1 => 'Multiple Choice Single Answer',
                    2 => 'Multiple Choice Multiple Answers',
                    3 => 'Fill In The Blank',

                    // Add more options if needed
                ])
                ->placeholder(__('Select question type'))
                ->title(__('Question Type'))
                ->required(),
            Button::make(__('Save'))
                ->type(Color::BASIC)
                ->icon('bs.check-circle')
                ->method('save')
                ->parameters(['runValidation' => true])



            // Add more fields as needed for other question details
        ];
    }
}
