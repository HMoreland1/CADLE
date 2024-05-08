<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Harishdurga\LaravelQuiz\Models\QuizAttempt;
use Harishdurga\LaravelQuiz\Models\QuizAttemptAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Integer;

class QuizAttemptController extends Controller
{
    public function startQuiz(Request $request)
    {

        // Get the quiz ID from the request
        $quizId = $request->route('quizId');
        $userId = $request->route('userId');
        // Find the quiz by ID
        $quiz = Quiz::findOrFail($quizId);

        // Check if the user has reached the maximum attempts for this quiz
        $quizAttemptsCount = QuizAttempt::where('participant_id', $userId)
            ->where('quiz_id', $quizId)
            ->count();

        if ($quizAttemptsCount >= $quiz->max_attempts) {
            return response()->json(['message' => 'You have reached the maximum number of quiz attempts for this quiz.'], 403);
        }

        // Create a new quiz attempt for the user
        $quizAttempt = QuizAttempt::create([
            'participant_id' => $userId,
            'quiz_id' => $quizId,
            'participant_type' => "user",
            // Add any other fields you need for the quiz attempt
        ]);
        return response()->json(['quiz_attempt' => $quizAttempt]);
    }

    public function evaluate(Request $request)
    {

        $quizAttemptId = $request->route('quizAttempt');
        $quizAttempt = QuizAttempt::find($quizAttemptId);
        // Validate the quiz attempt and calculate score
        $result = $quizAttempt->calculate_score();
        $result = $quizAttempt->evaluate();
        // You can return the result or perform any additional actions here
        return response()->json($result);
    }
    public function storeAnswers(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'quiz_attempt_id' => 'required|exists:quiz_attempts,id',
            'quiz_question_id' => 'required|exists:quiz_questions,id',
            'question_option_id' => 'required|exists:question_options,id',
        ]);

        // Create a new QuizAttemptAnswer entry
        $quizAttemptAnswer = QuizAttemptAnswer::create($validatedData);

        // Return the created QuizAttemptAnswer data
        return response()->json(['quiz_attempt_answer' => $quizAttemptAnswer], 201);
    }


    // Other controller methods...
}
