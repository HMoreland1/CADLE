<?php
namespace App\Orchid\Layouts\Quiz;

use App\Models\Question;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class QuestionListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'questions';


    /**
     * @return TD[]
     */
    public function columns(): array
    {

        return [
            // Checkbox column for selecting questions
            TD::make('selected', 'Add to Quiz')
                ->align(TD::ALIGN_CENTER)
                ->width('50px')
                ->cantHide()
                ->render(function (Question $question) {
                    $assignedQuestions = $this->query->get('assignedQuestions', []);
                    $isChecked = in_array($question->id, $assignedQuestions);
                    $quizTotalMarks = $this->query->get('quiz')->total_marks; // Assuming `$quiz` is accessible through `$this`

                    return "
            <input
                type='checkbox'
                name='selected_questions[]'
                value='$question->id'
                class='question-checkbox'
                data-quiz-total-marks='$quizTotalMarks'
                data-assigned-questions='" . json_encode($assignedQuestions) . "'
                " . ($isChecked ? 'checked' : '') . ">
        ";
                }),


            TD::make('name', __('Question'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

            TD::make('question_type_id', __('Question Type'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

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
                ->render(function (Question $question) {
                    return DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('platform.systems.questions.edit', $question)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Are you sure you want to delete this question?'))
                                ->method('remove', [
                                    'id' => $question->id,
                                ]),
                        ]);
                }),
        ];
    }


}
