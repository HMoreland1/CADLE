<?php

declare(strict_types=1);

use App\Http\Controllers\QuestionController;
use App\Orchid\Screens\Examples\ExampleActionsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleGridScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Quiz\QuestionEditScreen;
use App\Orchid\Screens\Quiz\QuestionListScreen;
use App\Orchid\Screens\Quiz\QuizEditScreen;
use App\Orchid\Screens\Quiz\QuizListScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Tabuna\Breadcrumbs\Trail;
use App\Orchid\Screens\TaskScreen;
/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/
// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

/*
|--------------------------------------------------------------------------
| Question Routes
|--------------------------------------------------------------------------
*/
Route::screen('quizzes/questions/{question}/edit', QuestionEditScreen::class)
    ->name('platform.systems.questions.edit')
    ->breadcrumbs(fn (Trail $trail, $question) => $trail
        ->parent('platform.systems.quizzes.edit', $question)
        ->push(__('Questions'), route('platform.systems.questions.edit', $question)));

Route::screen('quizzes/questions/create', QuestionEditScreen::class)
    ->name('platform.systems.questions.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.questions.create')
        ->push(__('Questions'), route('platform.systems.questions.create')));

Route::delete('/systems/question_options/remove/{id}', 'QuestionController@removeOption')->name('platform.systems.question_options.remove');



/*
|--------------------------------------------------------------------------
| Quiz Routes
|--------------------------------------------------------------------------
*/

Route::screen('quizzes', QuizListScreen::class)
    ->name('platform.systems.quizzes')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Quizzes'), route('platform.systems.quizzes')));

Route::screen('quizzes/create', QuizEditScreen::class)
    ->name('platform.systems.quizzes.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.quizzes')
        ->push(__('Create'), route('platform.systems.quizzes.create')));

Route::screen('quizzes/{quiz}/edit', QuizEditScreen::class)
    ->name('platform.systems.quizzes.edit')
    ->breadcrumbs(fn (Trail $trail, $quiz) => $trail
        ->parent('platform.systems.quizzes')
        ->push(__('Edit'), route('platform.systems.quizzes.edit', $quiz)));

Route::screen('quizzes/{quiz}/edit/questions', QuestionListScreen::class)
    ->name('platform.systems.quizzes.edit.questions')
    ->breadcrumbs(fn (Trail $trail, $quiz) => $trail
        ->parent('platform.systems.quizzes.edit', $quiz)
        ->push(__('Questions'), route('platform.systems.quizzes.edit.questions', $quiz)));




Route::screen('task', TaskScreen::class)->name('platform.task');
Route::post('/save-question-assignments', [QuestionController::class, 'save']);

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

/*
|--------------------------------------------------------------------------
| Role Routes
|--------------------------------------------------------------------------
*/
// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Example Screen'));

Route::screen('/examples/form/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('/examples/form/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
Route::screen('/examples/form/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('/examples/form/actions', ExampleActionsScreen::class)->name('platform.example.actions');

Route::screen('/examples/layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('/examples/grid', ExampleGridScreen::class)->name('platform.example.grid');
Route::screen('/examples/charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('/examples/cards', ExampleCardsScreen::class)->name('platform.example.cards');

//Route::screen('idea', Idea::class, 'platform.screens.idea');
