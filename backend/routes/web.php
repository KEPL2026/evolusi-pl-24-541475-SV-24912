<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->name('api.')->group(function (): void {
	Route::get('/tasks', [TaskController::class, 'apiIndex'])->name('tasks.index');
	Route::post('/tasks', [TaskController::class, 'apiStore'])->name('tasks.store');
});
