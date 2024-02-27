<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan semua tugas dari database
        $tasks = Task::latest()->paginate(10);

        if ($request->is('api/*') || $request->wantsJson()) {
            // Jika request berasal dari API, mengembalikan respons JSON yang dioptimalkan
            return response()->json([
                'tasks' => $tasks->items(),
                'pagination' => [
                    'current_page' => $tasks->currentPage(),
                    'last_page' => $tasks->lastPage(),
                    'per_page' => $tasks->perPage(),
                    'total' => $tasks->total(),
                ],
                'links' => [
                    'first_page_url' => $tasks->url(1),
                    'last_page_url' => $tasks->url($tasks->lastPage()),
                    'next_page_url' => $tasks->nextPageUrl(),
                    'prev_page_url' => $tasks->previousPageUrl(),
                ],
            ]);
        }

        $name = 'faisal';
        // Mengembalikan tampilan dengan data tugas
        return view('tasks.index', compact('name', 'tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(TaskRequest $request)
    {
        // The validation has already been performed by the 'validated' method
        $validatedData = $request->validated();

        // Create the task
        $task = Task::create($validatedData);

        // Return JSON response for API
        if ($request->is('api/*')) {
            return response()->json($task, 201);
        }

        // For web requests, redirect to the show page
        return redirect()->route('tasks.show', ['task' => $task->id]);
    }

    public function show(string $id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.show', compact('task'));
    }

    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    public function update(TaskRequest $request, Task $task)
    {
        // dd($request->all());

        // $task->update($request->validated());

        // if ($request->is('api/*')) {
        //     return response()->json($task, 200);
        // }

        // return redirect()->route('tasks.show', ['task' => $task->id]);
    }

    public function destroy(Request $request, Task $task)
    {
        try {
            $task->delete();

            if ($request->is('api/*')) {
                return response()->json(['message' => 'Task deleted successfully']);
            }

            return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('tasks.index')->with('error', 'Error deleting the task');
        }
    }

    // custom
    public function changeComplete(Request $request, Task $task) {
        $task->toggleComplete();

        if ($request->is('api/*')) {
            return response()->json($task, 200);
        }

        return redirect()->back()->with('success', 'Task updated successfully!');
    }
}
