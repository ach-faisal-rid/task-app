<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;
use App\Models\Task;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});

route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::resource('/tasks', TaskController::class);

Route::put('/tasks/{task}/change-complete',
[TaskController::class, 'changeComplete'])
    ->name('tasks.change-complete');

/** get */
/** post */
/** put */
/** delete */
/** get */
