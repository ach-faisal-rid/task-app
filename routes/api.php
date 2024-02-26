<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Display a listing of the resource
Route::get('/tasks', [TaskController::class, 'index']);

// Show the form for creating a new resource
Route::get('/tasks/create', [TaskController::class, 'create']);

// Store a newly created resource in storage
Route::post('/tasks', [TaskController::class, 'store']);

// Display the specified resource
Route::get('/tasks/{id}', [TaskController::class, 'show']);

// Show the form for editing the specified resource
Route::get('/tasks/{id}/edit', [TaskController::class, 'edit']);

// Update the specified resource in storage
Route::put('/tasks/{task}', [TaskController::class, 'update']);

// Remove the specified resource from storage
Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);

// Custom route to change task completion status
Route::patch('/tasks/{task}/complete', [TaskController::class, 'changeComplete']);
