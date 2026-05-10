<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnalyzeController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\Admin\AnalysisExportController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/analyze', [AnalyzeController::class, 'index'])->name('analyze');
Route::post('/analyze', [AnalyzeController::class, 'analyze'])->name('analyze.post');
Route::get('/result/{sessionId}', [ResultController::class, 'show'])
    ->middleware('auth')
    ->name('result.show');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/history', [HistoryController::class, 'index'])->name('history');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    Route::delete('/profile/reset-test-account', [ProfileController::class, 'destroy'])
        ->name('profile.reset-test-account');
    
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])
    ->middleware('auth')
    ->name('profile.password.update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/analyses/export', [AnalysisExportController::class, 'download'])->name('analyses.export');
    
    // Food Management
    Route::get('foods/import', [FoodController::class, 'importForm'])->name('foods.import.form');
    Route::post('foods/import/preview', [FoodController::class, 'previewImport'])->name('foods.import.preview');
    Route::post('foods/import/confirm', [FoodController::class, 'confirmImport'])->name('foods.import.confirm');
    Route::post('foods/import/cancel', [FoodController::class, 'cancelImport'])->name('foods.import.cancel');
    Route::resource('foods', FoodController::class);

    // User Management
    Route::resource('users', UserController::class)->except(['show']);
});

require __DIR__.'/auth.php';
