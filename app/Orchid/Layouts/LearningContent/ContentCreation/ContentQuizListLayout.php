<?php


declare(strict_types=1);

namespace App\Orchid\Layouts\LearningContent\ContentCreation;

use App\Models\LearningContent;
use App\Models\Quiz;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ContentQuizListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'quizzes';

    /**
     * @return TD[]
     */

    public function columns(): array
    {
        return [
            TD::make('selected', 'Add to Quiz')
                ->align(TD::ALIGN_CENTER)
                ->width('50px')
                ->cantHide()
                ->render(function (Quiz $quiz) {
                    $isChecked = ($quiz->id == $this->query->get('content')->quiz_id);
                    return "
            <input
                type='checkbox'
                name='selected_quiz'
                class='content-quiz-checkbox'
                value='$quiz->id'
                " . ($isChecked ? 'checked' : '') . ">
        ";
                }),
            TD::make('name', __('Name'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn(Quiz $quiz) => Link::make($quiz->name)
                    ->route('platform.systems.quizzes.edit', $quiz)),

            TD::make('description', __('Description'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

            TD::make('created_at', __('Created'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->defaultHidden()
                ->sort(),

            TD::make('updated_at', __('Last edit'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->sort(),

        ];
    }

}
