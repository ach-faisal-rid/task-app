<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = Task::latest()->paginate(10);

        if ($request->is('api/*')) {
            return response()->json($tasks);
        }

        $name = 'faisal';
        return view('tasks.index', compact('name', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        // dd($request->all());

        $task->update($request->validated());

        if ($request->is('api/*')) {
            return response()->json($task, 200);
        }

        return redirect()->route('tasks.show', ['task' => $task->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Task $task)
    {
        $task->delete();

        if ($request->is('api/*')) {
            return response()->json(['message' => 'Task deleted successfully']);
        }

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
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
