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

class QuestionOptionsEditLayout extends Rows
{

    public $title = 'Add a new option';
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('question_option.name')
                ->type('text')
                ->max(255)
                ->title(__('Option'))
                ->placeholder(__('Enter the option')),



            Select::make('question_option.is_correct')
                ->options([
                    false => 'No',
                    true => 'Yes',

                    // Add more options if needed
                ])
                ->title(__('Correct Answer?')),
            Button::make(__('Add'))
                ->type(Color::BASIC)
                ->icon('bs.check-circle')
                ->method('addOption')
                ->parameters(['runValidation' => true])
            // Add more fields as needed for other option details
        ];
    }
}
