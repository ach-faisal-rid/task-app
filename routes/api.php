<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [UserController::class, 'register']);

// Login
Route::post('/login', [UserController::class, 'login']);

// Informasi Pengguna Saat Ini
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [UserController::class, 'currentUser']);

    // ketika user ingin memperbaharui email, username, name
    Route::patch('/user', [UserController::class, 'updateCurrentUser']);

    // Penggantian Kata Sandi
    Route::post('/change-password', [UserController::class, 'changePassword']);

    // ketika user akan keluar dari sistem(logout)
    Route::post('/logout', [UserController::class, 'logout']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Use apiResource to simplify route declaration
// Route::apiResource('/tasks', TaskController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

 Route::get('/tasks', [TaskController::class, 'index']);
 Route::post('/tasks', [TaskController::class, 'store']);
 Route::get('/tasks/{task}', [TaskController::class, 'show']);
 Route::put('/tasks/{task}', [TaskController::class, 'update']);
 Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);

Route::patch('/tasks/{task}/complete', [TaskController::class, 'changeComplete'])->name('tasks.complete');
