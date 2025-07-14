<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\TaskStatusController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::resource('task_statuses', TaskStatusController::class)->only(['index']);
Route::resource('tasks', TaskController::class)->only(['index', 'show']);
Route::resource('labels', LabelController::class)->only(['index']);


Route::middleware(['auth'])->group(function () {

    Route::resource('task_statuses', TaskStatusController::class)->except(['index']);

    Route::resource('tasks', TaskController::class)->except(['index', 'show']);

    Route::resource('labels', LabelController::class)->except(['index']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
