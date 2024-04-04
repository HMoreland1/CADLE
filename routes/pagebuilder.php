<?php

use App\Http\Middleware\RedirectIfNotAuthenticated;
use Larabuild\Pagebuilder\Http\Controllers\PageBuilderController;
use Larabuild\Pagebuilder\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

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

$page = Route::controller(PageController::class);
$pBuilder = Route::controller(PageBuilderController::class);

if (!empty(config('pagebuilder.url_prefix'))) {
    $page = $page->prefix(config('pagebuilder.url_prefix'));
    $pBuilder = $pBuilder->prefix(config('pagebuilder.url_prefix'));
}

$page->middleware(RedirectIfNotAuthenticated::class); // Use the custom middleware instead of 'auth'
$pBuilder->middleware(RedirectIfNotAuthenticated::class); // Use the custom middleware instead of 'auth'


$page->group(function () {
    Route::get('pages', 'index')->name('pagebuilder');
    Route::get('pages/{page}/edit', 'edit')->name('page.edit');
    Route::post('pages', 'store')->name('page.store');
    Route::put('pages/{page}', 'update')->name('page.update');
    Route::get('pages/create', 'create')->name('page.create');
    Route::delete('pages/{page}', 'destroy')->name('page.delete');
});

$pBuilder->group(function () {
    Route::post('get-section-settings', 'getSettings')->name('get-section-settings');
    Route::post('set-section-settings', 'setSectionSettings')->name('set-section-settings');
    Route::post('set-page-settings', 'setPageSettings')->name('set-page-settings');
    Route::post('get-section-html', 'getPageSectionHtml')->name('get-section-html');
    Route::get('pages/{id}/build', 'build')->name('pagebuilder.build');
    Route::post('pages/{id}/store', 'storeComponentData');
});

Route::middleware('auth')->get('pages/{id}/iframe', [PageBuilderController::class, 'iframe'])->name('pagebuilder.iframe');

Route::middleware('auth')->any('/{any}', function () {
    $builder = new PageBuilderController();
    return $builder->renderPage(request()->path());
})->where('any', '.*')->name('pagebuilder.page');
