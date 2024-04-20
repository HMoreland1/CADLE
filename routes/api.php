<?php

use App\Http\Controllers\Components\UserLearningController;
use App\Http\Controllers\LearningContentController;
use App\Http\Controllers\PathwayController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizAttemptController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SCORMCreatorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Route to fetch learning content assigned directly to a user
Route::get('/learning-content/user/{userId}', [UserLearningController::class, 'getAssignedContentForUser']);
Route::get('/learning-content/user/{userId}/status', [UserLearningController::class, 'getAssignedContentCompletionStatus']);


Route::get('learning-content/all', [LearningContentController::class, 'getAllContent']);
Route::get('/learning-content/pathway/{pathwayId}', [LearningContentController::class, 'getPathwayContent']);

Route::get('/scorm-creator', [SCORMCreatorController::class, 'index'])->name('scorm-creator');

// Route to fetch learning content assigned to a user through their roles
Route::get('/learning-content/role/{userId}', [UserLearningController::class, 'getAssignedContentForUserRole']);

Route::post('/quiz-attempts/user/{userId}/quiz/{quizId}/start', [QuizAttemptController::class, 'startQuiz']);

Route::get('/quiz-attempts/{quizAttempt}/evaluate', [QuizAttemptController::class, 'evaluate']);

Route::post('/quiz-attempts/storeAnswer', [QuizAttemptController::class, 'storeAnswers']);


Route::get('/pathways', [PathwayController::class, 'index']);

Route::post('/save-question-assignments', [QuestionController::class, 'save']);
Route::delete('/systems/question_options/remove/{id}', [QuestionController::class, 'removeOption'])->name('platform.systems.question_options.remove');
