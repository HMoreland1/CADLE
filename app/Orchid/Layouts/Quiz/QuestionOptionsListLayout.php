<?php

namespace App\Orchid\Layouts\Quiz;

use App\Models\QuestionOption;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class QuestionOptionsListLayout extends Table
{
    /**
     * @var string
     */
    public $title = 'Current Options';
    public $target = 'options';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('name', __('Option'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

            TD::make('is_correct', __('Is Correct'))
                ->align(TD::ALIGN_CENTER)
                ->cantHide()
                ->render(function (QuestionOption $option) {
                    return $option->is_correct ? 'Yes' : 'No';
                }),

            TD::make('created_at', __('Created'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->defaultHidden()
                ->sort(),

            TD::make('updated_at', __('Last Edit'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->sort(),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (QuestionOption $option) {
                    return DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            //Link::make(__('Edit'))
                               // ->route('platform.systems.question_options.edit', $option)
                               // ->icon('pencil'),

                            button::make(__('Delete'))
                                ->icon('trash')
                                ->method('removeOption', [
                                    'id' => $option->id,
                                ])



                        ]);
                }),
        ];
    }

}

