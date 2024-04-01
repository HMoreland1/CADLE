<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Quiz;
use App\Models\Question;
use App\Orchid\Layouts\Quiz\QuestionListLayout;
use App\Models\Quiz;
use Harishdurga\LaravelQuiz\Models\QuizQuestion;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class QuestionListScreen extends Screen
{
    public $quiz;
    public $totalMarks;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(?Quiz $quiz): array
    {

        $assignedQuestions = [];
        $questions = Question::filters()
            ->defaultSort('id', 'desc')
            ->paginate(5);
        echo $questions . " ";

        if ($quiz !== null) {
            $assignedQuestions = QuizQuestion::where('quiz_id', $quiz->id)->pluck('question_id')->toArray();
            return [
                'quiz' => $quiz,
                'questions' => $questions,
                'assignedQuestions' => $assignedQuestions
            ];
        }
        return [
            'quiz' => new Quiz(), // Empty quiz object
            'assignedQuestions' => [],
            'questions' => $questions,
        ];
    }


    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Question Management';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all Questions.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.users',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save Question Assignments'))
                ->icon('bs.check-circle')
                ->id('saveButton')
                ->method('save'),

            Link::make(__('Add'))
                ->icon('bs.plus-circle')
                ->route('platform.systems.questions.create'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {

        return [

            QuestionListLayout::class,
            Layout::view('Questions/QuestionsCheckbox', [
                'quiz' => $this->quiz,
                'quizTotalMarks' => $this->quiz->total_marks,
            ]),

        ];

    }

    /**
     * @return array
     */


    public function remove(Request $request): void
    {
        Question::findOrFail($request->get('id'))->delete();

        Toast::info(__('Question was removed'));
    }

    public function save(Request $request)
    {
        $selectedQuestions = $request->input('selected_questions');

        if ($selectedQuestions === null) {
            $selectedQuestions = [];
        }

        // Calculate the total number of selected questions
        $totalSelectedQuestions = count($selectedQuestions);

        // Validate if the total number of selected questions exceed the total marks of the quiz
        if ($totalSelectedQuestions > $this->quiz->total_marks) {
            // If the total number of selected questions exceed the total marks of the quiz, display an error message
            Toast::error('Total number of selected questions exceed the total marks of the quiz.');
            return;
        }

        // Assign selected questions to the quiz
        foreach ($selectedQuestions as $questionId) {
            QuizQuestion::updateOrCreate(
                ['quiz_id' => $this->quiz->id, 'question_id' => $questionId],
                ['marks' => 1, 'order' => 1, 'negative_marks' => 1, 'is_optional' => false]
            );
        }

        // Remove unselected questions from the quiz
        if (empty($selectedQuestions)) {
            // If no questions are selected, remove all question assignments for the quiz
            QuizQuestion::where('quiz_id', $this->quiz->id)->delete();
        } else {
            // Remove only unselected questions from the quiz
            QuizQuestion::where('quiz_id', $this->quiz->id)
                ->whereNotIn('question_id', $selectedQuestions)
                ->delete();
        }

        // Display success message
        Toast::info('Question assignments saved successfully.');
    }






}
