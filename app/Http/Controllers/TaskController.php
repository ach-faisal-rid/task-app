<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;

use Illuminate\Http\Response; // For clarity

use App\Models\Task;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        $data = Task::orderBy('title', 'ASC')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data Ditemukan',
            'data' => $data
        ], 200);
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $dataTask = new Task;

        $rules = [
            'title' => 'required|string|max:255', // Specify a maximum length for title
            'description' => 'required|string',
            'long_description' => 'required|string',
            'completed' => 'required|boolean', // Ensure completed is a boolean
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Return a more specific error message with validation details
            return response()->json([
                'status' => false,
                'message' => 'Validation failed: ' . $validator->messages()->first(),
                'data' => $validator->errors()->toArray()
            ], 422); // Set appropriate HTTP status code for validation errors
        }

        $dataTask->title = $request->title;
        $dataTask->description = $request->description;
        $dataTask->long_description = $request->long_description;
        $dataTask->completed = $request->completed;

        $dataTask->save();

        // Return a success response with the created task data
        return response()->json([
            'status' => true,
            'message' => 'Task created successfully!',
            'data' => $dataTask
        ], 201); // Use HTTP status code 201 for resource creation
    }

    public function show(string $id)
    {
        $data = Task::find($id);
        if($data) {
            return response()->json([
                'status' => true,
                'message' => 'Data Ditemukan',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 400);
        }
    }

    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, string $id)
    {
        // dd($request->all());

        $dataTask = Task::findOrFail($id);
        if(!$dataTask){
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 400);
        }

        $rules = [
            'title' => 'required|string|max:255', // Specify a maximum length for title
            'description' => 'required|string',
            'long_description' => 'required|string',
            'completed' => 'required|boolean', // Ensure completed is a boolean
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Return a more specific error message with validation details
            return response()->json([
                'status' => false,
                'message' => 'Validation failed: ' . $validator->messages()->first(),
                'data' => $validator->errors()->toArray()
            ], 422); // Set appropriate HTTP status code for validation errors
        }

        $dataTask->title = $request->title;
        $dataTask->description = $request->description;
        $dataTask->long_description = $request->long_description;
        $dataTask->completed = $request->completed;

        $dataTask->save();

        // Create and save the task with mass assignment for efficiency
        //$task = Task::create($request->all());

        // Return a success response with the created task data
        return response()->json([
            'status' => true,
            'message' => 'Task updated successfully!',
            'data' => $dataTask
        ], 201); // Use HTTP status code 201 for resource creation
    }

    public function destroy($id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'status' => false,
                'message' => "ID task harus berupa angka.",
            ], 400);
        }

        $dataTask = Task::findOrFail($id);

        if (!$dataTask) {
            return response()->json([
                'status' => false,
                'message' => "Data task dengan ID {$id} tidak ditemukan.",
            ], 400);
        }

        try {
            $dataTask->delete();

            return response()->json([
                'status' => true,
                'message' => 'Task berhasil dihapus!',
            ], 200); // Use 200 for successful deletion
        } catch (\Exception $e) {
            // Handle potential deletion errors
            return response()->json([
                'status' => false,
                'message' => "Gagal menghapus task: {$e->getMessage()}",
            ], 500); // Use 500 for internal server errors
        }
    }

    // custom
    public function changeComplete(Request $request, Task $task) {
        // masih belum dibuat
    }
}
