<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

use App\Models\Task;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        // Mendapatkan semua tugas dari database
        $localTasks = Task::latest()->select('id', 'title')->paginate(10);

        // Mendapatkan semua tugas dari REST API
        $response = Http::timeout(60)->get('http://task-app.test/api/tasks');
        $apiTasks = $response->json();

        // Check if $apiTasks['tasks'] is set and not null, otherwise use an empty array
        $apiTasksArray = $apiTasks['tasks'] ?? [];

        // Gabungkan data dari database dan API
        $mergedTasks = array_merge($localTasks->items(), $apiTasksArray);

        // Buat objek LengthAwarePaginator dari hasil gabungan
        $perPage = 10; // Sesuaikan dengan jumlah tugas per halaman yang diinginkan
        $currentPage = request()->get('page', 1); // Dapatkan nomor halaman saat ini dari URL

        $paginator = new LengthAwarePaginator(
            array_slice($mergedTasks, ($currentPage - 1) * $perPage, $perPage),
            count($mergedTasks),
            $perPage,
            $currentPage
        );

        $paginator->withPath(route('tasks.index')); // Sesuaikan dengan nama rute halaman tugas Anda

        // Jika request berasal dari API, kembalikan respons JSON yang dioptimalkan
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'tasks' => $paginator->items(),
                'pagination' => [
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                ],
                'links' => [
                    'first_page_url' => $paginator->url(1),
                    'last_page_url' => $paginator->url($paginator->lastPage()),
                    'next_page_url' => $paginator->nextPageUrl(),
                    'prev_page_url' => $paginator->previousPageUrl(),
                ],
            ]);
        }

        // Jika request bukan dari API, tampilkan halaman web dengan data tugas
        $name = 'Faisal';

        return view('tasks.index', compact('name', 'paginator'));
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
