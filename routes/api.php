<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;

Route::apiResource('projects', ProjectController::class);
Route::apiResource('tasks', TaskController::class);

// Filtrage des tâches assignées à un user
Route::get('tasks-assigned', [TaskController::class, 'assignedTo']);
Route::get('/debug-route', fn () => response()->json(['ok' => true]));
