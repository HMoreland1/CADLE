<?php

namespace App\Orchid\Screens\Quiz;

use App\Models\Question;
use App\Orchid\Layouts\Quiz\QuestionEditLayout;
use App\Orchid\Layouts\Quiz\QuestionOptionsEditLayout;
use App\Orchid\Layouts\Quiz\QuestionOptionsListLayout;
use App\Models\QuestionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class QuestionEditScreen extends Screen
{
    /**
     * @var Question
     */
    public $question;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @param Question $question
     * @return array
     */
    public function query(?Question $question): array
    {


// Inside the query method of your screen class
        if ($question !== null) {
            $options = QuestionOption::where('question_id', $question->id)->paginate(10);
        } else {
            // Create an empty paginator with an empty collection of items
            $options = new LengthAwarePaginator(new Collection(), 0, 10);
        }

        return [
            'question' => $question ?? new Question(),
            'options' => $options,
        ];

    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->question->exists ? 'Edit Question' : 'Create Question';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Create or edit a question';
    }

    /**
     * The screen's action buttons.
     *
     * @return array
     */
    public function commandBar(): array
    {
        if ($this->question && $this->question->exists) {
            $buttons = [
                Button::make(__('Save'))
                    ->icon('bs.check-circle')
                    ->method('save'),
            ];
        } else {
            $buttons = [
                Button::make(__('Save'))
                    ->icon('bs.check-circle')
                    ->method('save'),
            ];
        }

        return $buttons;
    }

    /**
     * Define the layout of the screen.
     *
     * @return \Orchid\Screen\Layout[]
     */


    public function layout(): array
    {
        return [
            QuestionEditLayout::class,
            QuestionOptionsListLayout::class,
            QuestionOptionsEditLayout::class,



            // Additional layouts for other details of the question if needed
        ];
    }
    public function removeOption(int $id)
    {
        // Find the question option by ID
        $option = QuestionOption::findOrFail($id);

        // Delete the question option
        $option->delete();

        // Show a toast message indicating successful option deletion
        Toast::success('Option removed successfully.');
    }
    public function addOption(Request $addRequest, $runValidation)
    {
        // Validate the request data for adding option
        if ($runValidation) {
            $addValidator = Validator::make($addRequest->all(), [
                'question_option.name' => 'required|string|max:255',
                'question_option.is_correct' => 'required|boolean',
            ]);

            // If validation fails, redirect back with errors
            if ($addValidator->fails()) {
                return redirect()->back()->withErrors($addValidator)->withInput();
            }
        }

        // Create a new question option instance
        $option = new QuestionOption();
        $option->name = $addRequest->input('question_option.name');
        $option->is_correct = $addRequest->input('question_option.is_correct');
        $option->question_id = $this->question->id; // Assign the question ID

        // Save the question option to the database
        $option->save();

        // Show a toast message indicating successful option addition
        Toast::success('Option added successfully.');

        // Redirect back to the previous page or to a specific route
        return redirect()->back();
    }


    /**
     * Save the question details.
     *
     * @param Request $request
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $saveRequest, Question $question, $runValidation): \Illuminate\Http\RedirectResponse
    {
        // Validation rules for saving question
        if ($runValidation) {
            $saveValidator = Validator::make($saveRequest->all(), [
                'question.name' => 'required|string|max:255',
                'question.question_type_id' => 'required|exists:question_types,id',
            ]);

            // If validation fails, redirect back with errors
            if ($saveValidator->fails()) {
                return Redirect::back()->withErrors($saveValidator)->withInput();
            }
        }

        $question->fill($saveRequest->get('question'));
        $question->save();

        Toast::info(__('Question was saved'));
        return redirect()->route('platform.systems.questions.edit', $question);
    }


}
