<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->group(function () {

//     Route::get('/tasks', [TaskController::class, 'index']);
//     Route::post('/tasks', [TaskController::class, 'store']);
//     Route::patch('/tasks/{id}/status', [TaskController::class, 'updateStatus']);
//     Route::get('/tasks/{id}/ai-summary', [TaskController::class, 'aiSummary']);

// });

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::get('/tasks/{id}', [TaskController::class, 'show']);
    Route::patch('/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);

    // Update only status
    Route::patch('/tasks/{id}/status', [TaskController::class, 'updateStatus']);

    // AI summary endpoint
    Route::get('/tasks/{id}/ai-summary', [TaskController::class, 'aiSummary']);
});


