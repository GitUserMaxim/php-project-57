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


Route::resource('tasks', TaskController::class)->only(['index', 'show']);

Route::resource('task_statuses', TaskStatusController::class)
    ->middleware('auth');
 
    Route::resource('labels', LabelController::class)->except(['show']);

    Route::resource('tasks', TaskController::class)->except(['index', 'show']);


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

require __DIR__.'/auth.php';
