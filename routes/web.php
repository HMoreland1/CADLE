<?php

use App\Http\Controllers\LearningContentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SCORMCreatorController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
require __DIR__.'/optionbuilder.php';


Route::get('/popup', function () {
    return inertia('PopupComponent');
});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome'); // Assigning the name 'welcome' to the route


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/catalogue', function () {
    return Inertia::render('Catalogue');
})->middleware(['auth', 'verified'])->name('catalogue');

Route::get('/pathways', function () {
    return Inertia::render('Pathways');
})->middleware(['auth', 'verified'])->name('pathways');

Route::get('/help', function () {
    return Inertia::render('Help');
})->middleware(['auth', 'verified'])->name('help');

Route::get('/content/{learningContent}', [LearningContentController::class, 'displayContent'])
    ->middleware(['auth', 'verified'])
    ->name('displayContent');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/scorm/creator', function () {
    return Inertia::render('SCORM/SCORMCreator');
})->middleware(['auth', 'verified'])->name('scorm.creator');


require __DIR__.'/auth.php';
require __DIR__.'/pagebuilder.php';


