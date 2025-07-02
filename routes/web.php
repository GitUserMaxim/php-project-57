<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\TaskStatusController;
use App\Http\Controllers\ProfileController;

// Главная страница
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// === Публичные ===
Route::resource('tasks', TaskController::class)->only(['index', 'show']);
Route::resource('task_statuses', TaskStatusController::class)->only(['index', 'show']);

// === Только авторизованные ===
Route::middleware(['auth'])->group(function () {
    // Остальные методы task_statuses
    Route::resource('task_statuses', TaskStatusController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy']);

    // Все методы labels кроме show
    Route::resource('labels', LabelController::class)->except(['show']);

    // Остальные методы tasks кроме index, show
    Route::resource('tasks', TaskController::class)->except(['index', 'show']);

    // Профиль
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
