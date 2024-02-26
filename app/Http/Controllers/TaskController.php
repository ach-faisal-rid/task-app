<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $name = 'faisal';
        $tasks = Task::latest()->paginate(10);
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
        // dd($request->all());

        $task = Task::create($request->validated());

        $task->save();

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
        $task->save();

        return redirect()->route('tasks.show', ['task' => $task->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
        ->with('success', 'task deleted successfully!');
    }

    // custom
    public function changeComplete(Task $task) {
        $task->toggleComplete();

        return redirect()->back()
        ->with('success', 'Task updated successfully!');
    }
}
