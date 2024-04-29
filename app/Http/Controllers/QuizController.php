<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\UserAssignedContent;
use App\Models\UserRoleAssignedContent;
use Harishdurga\LaravelQuiz\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class QuizController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show(Quiz $quiz)
    {
        return view('quiz.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit(Quiz $quiz)
    {
        return view('quiz.edit', compact('quiz'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'slug' => 'required|string|max:255|unique:quizzes,slug,' . $quiz->id,
        ]);

        $quiz->update($request->all());

        return redirect()->route('platform.quiz')
            ->with('success', 'Quiz updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('platform.quiz')
            ->with('success', 'Quiz deleted successfully.');
    }



    public function showQuiz(  $quizId, $learningContent = null,)
    {
        // Fetch the quiz data along with its associated quiz questions and questions
        $quiz = Quiz::with(['quizQuestions', 'questions.questionOptions'])->find($quizId);
        // Return the quiz data as JSON response
        return Inertia::render('Quiz', [
            'quiz' => $quiz,
            'content' =>$learningContent,
        ]);
    }


    public function showQuizResult($contentId = null, $quizId, $attemptId,)
    {

        // Fetch the quiz data along with its associated quiz questions and questions
        $quiz = Quiz::with(['quizQuestions', 'questions.questionOptions'])->find($quizId);

        // Find the quiz attempt
        $quizAttempt = QuizAttempt::find($attemptId);

        // Validate the quiz attempt and calculate score

        $result = $quizAttempt->calculate_score();


        // Check if the user has the content assigned to them
        $contentAssignment = UserAssignedContent::where('user_id', auth()->id())
            ->where('content_id', $contentId)
            ->first();

        if(!$contentAssignment){
            $contentAssignment = UserRoleAssignedContent::where('user_id', auth()->id())
                ->where('content_id', $contentId)
                ->first();
        }

        // If the content is assigned and the user passed the quiz, mark the content assignment as completed
        if ($contentAssignment && $result >= $quiz->pass_marks) {
            $contentAssignment->completed = true;
            $contentAssignment->save();
        }

        // Return the quiz data as JSON response
        return Inertia::render('ContentComplete', [
            'quiz' => $quiz,
            'content' => $contentId,
            'score' => $result,
            'val' => $quizAttempt->validate()
        ]);
    }




}
