<?php
namespace App\Orchid\Screens\Quiz;
use App\Orchid\Layouts\Quiz\QuestionListLayout;
use App\Orchid\Layouts\Quiz\QuizEditLayout;
use App\Models\Quiz;

use App\Orchid\Layouts\Quiz\QuizListLayout;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use phpDocumentor\Reflection\DocBlock\Tags\Method;

class QuizEditScreen extends Screen
{
    /**
     * @var Quiz
     */
    public $quiz;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @param Quiz $quiz
     * @return array
     */
    public function query(?Quiz $quiz): array
    {
        $questions = Question::filters()
            ->defaultSort('id', 'desc')
            ->paginate(5);

        if ($quiz !== null) {
            return [
                'quiz' => $quiz,
                'questions' => $questions,
            ];
        }

        return [
            'quiz' => new Quiz(), // Create a new quiz object if $quiz is null
            'questions' => $questions,
        ];
    }


    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->quiz->exists ? 'Edit Quiz' : 'Create Quiz';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Create or edit a quiz';
    }


    public function commandBar(): iterable
    {


        // Check if $this->quiz is set and exists
        if ($this->quiz && $this->quiz->exists) {
            $buttons = [Link::make(__('Edit Questions'))
                            ->route('platform.systems.quizzes.edit.questions', ['quiz' => $this->quiz])
                            ->icon('pencil'),
                        Button::make(__('Save'))
                            ->icon('bs.check-circle')
                            ->method('save'),
                        ];
        }
        else{
            $buttons = [
                Button::make(__('Save'))
                    ->icon('bs.check-circle')
                    ->method('save')

            ];

        }



        return $buttons;
    }
    public function questionroute(): string
    {
        route('platform.systems.quizzes.edit.questions', $this->quiz);
        return "";
    }
    public function permission(): ?iterable
    {
        return [
            'platform.systems.quizzes',
        ];
    }
    /**
     * Define the layout of the screen.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(QuizEditLayout::class)
                ->title(__('Quiz Details'))
                ->description(__('Enter quiz details'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('save', ['id' => $this->quiz->id])
                ),



            // Additional layouts for other details of the quiz if needed
        ];
    }

    /**
     * Save the quiz details.
     *
     * @param Quiz $quiz
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, Quiz $quiz): \Illuminate\Http\RedirectResponse
    {
        // Validation rules
        $rules = [
            'quiz.name' => 'required|string|max:255',
            'quiz.description' => 'nullable|string',
            'quiz.total_marks' => 'required|numeric|min:0',
            'quiz.pass_marks' => 'required|numeric|min:0',
            'quiz.max_attempts' => 'required|numeric|min:1',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $quiz->fill($request->get('quiz'));

        // Assuming 'permissions' is a field in the Quiz model, adjust this part accordingly

        $quiz->save();

        Toast::info(__('Quiz was saved'));
        Toast::info('Quiz saved successfully.', 'success');
        return redirect()->route('platform.systems.quizzes.edit', $quiz);
    }

}
