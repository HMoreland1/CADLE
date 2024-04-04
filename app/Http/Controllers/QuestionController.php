<?php
namespace App\Http\Controllers;

use App\Models\QuestionOption;
use Illuminate\Http\Request;
use App\Models\QuizQuestion;
use App\Models\Quiz;

class QuestionController extends Controller
{
    public function save(Request $request)
    {
        $quizId = $request->input('quiz_id');
        $selectedQuestions = $request->input('selected_questions');

        if ($selectedQuestions === null) {
            $selectedQuestions = [];
        }

        // Retrieve the quiz based on the provided quiz ID
        $quiz = Quiz::find($quizId);

        // Calculate the total number of selected questions
        $totalSelectedQuestions = count($selectedQuestions);

        // Validate if the total number of selected questions exceed the total marks of the quiz
        if ($quiz && $totalSelectedQuestions > $quiz->total_marks) {
            // If the total number of selected questions exceed the total marks of the quiz, return an error response
            return response()->json(['message' => 'Total number of selected questions exceed the total marks of the quiz.'], 422);
        }

        // Assign selected questions to the quiz
        foreach ($selectedQuestions as $questionId) {
            QuizQuestion::updateOrCreate(
                ['quiz_id' => $quizId, 'question_id' => $questionId],
                ['marks' => 1, 'order' => 1, 'negative_marks' => 1, 'is_optional' => false]
            );
        }

        // Remove unselected questions from the quiz
        if (empty($selectedQuestions)) {
            // If no questions are selected, remove all question assignments for the quiz
            QuizQuestion::where('quiz_id', $quizId)->delete();
        } else {
            // Remove only unselected questions from the quiz
            QuizQuestion::where('quiz_id', $quizId)
                ->whereNotIn('question_id', $selectedQuestions)
                ->delete();
        }

        // Return a success response
        return response()->json(['message' => 'Question assignments saved successfully.']);
    }
    public function removeOption($id)
    {
        // Fetch the question option
        $option = QuestionOption::findOrFail($id);

        // Delete the option
        $option->delete();

        // Redirect back or to any other appropriate page
        return redirect()->back()->with('success', 'Option deleted successfully');
    }
}

