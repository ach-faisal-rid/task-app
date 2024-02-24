<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

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

Route::get('/', function(){
    return redirect()->route('tasks.index');
});
Route::get('/tasks', function () {
    return view('home/index', [
        'name' => 'faisal',
        'tasks'=> \App\Models\Task::latest()->get()
    ]
    );
})->name('tasks.index');

Route::get('/tasks/{id}', function ($id) {

    return view('home/show',
        ['task'=> \App\Models\Task::findorFail($id)]
    );
})->name('tasks.show');

Route::fallback(function (){
    return 'still got somewhere';
});

/** get */
/** post */
/** put */
/** delete */
/** get */
