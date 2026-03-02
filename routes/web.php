<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



require __DIR__.'/auth.php';

Route::middleware(['auth','verified'])->group(function () {

    Route::resource('tasks', TaskController::class);

    Route::patch('/tasks/{id}/status',
        [TaskController::class, 'updateStatus']
    )->name('tasks.updateStatus');

});

Route::middleware(['auth','admin'])->group(function () {

    Route::get('/users', [TaskController::class, 'usersList'])
        ->name('users.index');

    Route::put('/users/{id}', [TaskController::class, 'userUpdate'])
        ->name('users.update');
});




