<?php

use App\Http\Controllers\BattleController;
use App\Http\Controllers\CreatorController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;
use Laracasts\Cypress\Controllers\CypressController;
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

Route::get('/', [\App\Http\Controllers\StaticPageController::class, 'welcome'])->name('welcome');
Route::get('/faq', [\App\Http\Controllers\StaticPageController::class, 'faq'])->name('faq');

Route::get('/creators', [CreatorController::class, 'index'])->name('creators');
Route::get('/creators/{creator}', [CreatorController::class, 'show'])->name('creator');

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::post('/search', [SearchController::class, 'search'])->name('search.create');
Route::get('/adv-search', [SearchController::class, 'advanceIndex'])->name('adv.search');
Route::post('/adv-search', [SearchController::class, 'advanceSearch'])->name('adv.search.create');


Route::middleware(['auth'])->group(function() {
    Route::get('/history', [SearchController::class, 'history'])->name('search.history');
    Route::get('/searchagain', function() { redirect()->route('search');});
    Route::post('/searchagain', [SearchController::class, 'searchagain'])->name('search.again');
});


// Admin (Editing section)
Route::middleware(['auth.admin'])->group(function() {
    Route::get('/admin/dashboard', function() {
        return Inertia\Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard');

    //Content Creators
    Route::get('/admin/creators', [CreatorController::class, 'create'])->name('admin.creators');
    Route::post('/admin/creators', [CreatorController::class, 'store'])->name('admin.creators.store');
    Route::delete('/admin/creators/{creator}', [CreatorController::class, 'destroy'])->name('admin.creators.destroy');
    Route::put('/admin/creators/{creator}', [CreatorController::class, 'update'])->name('admin.creators.update');

    //Videos Saved
    Route::get('/admin/videos', [VideoController::class, 'create'])->name('admin.videos');
    Route::post('/admin/videos', [VideoController::class, 'store'])->name('admin.videos.store');
    Route::delete('/admin/videos/{video}', [VideoController::class, 'destroy'])->name('admin.videos.destroy');
    Route::put('/admin/videos/{video}', [VideoController::class, 'update'])->name('admin.videos.update');

    //Teams Saved
    Route::get('/admin/teams', [TeamController::class, 'create'])->name('admin.teams');
    Route::post('/admin/teams', [TeamController::class, 'store'])->name('admin.teams.store');
    Route::delete('/admin/teams/{team}', [TeamController::class, 'destroy'])->name('admin.teams.destroy');
    Route::put('/admin/teams/{team}', [TeamController::class, 'update'])->name('admin.teams.update');

    //Battles Saved
    Route::get('/admin/battles', [BattleController::class, 'create'])->name('admin.battles');
    Route::post('/admin/battles', [BattleController::class, 'store'])->name('admin.battles.store');
    Route::delete('/admin/battles/{battle}', [BattleController::class, 'destroy'])->name('admin.battles.destroy');
    Route::put('/admin/battles/{battle}', [BattleController::class, 'update'])->name('admin.battles.update');

});


