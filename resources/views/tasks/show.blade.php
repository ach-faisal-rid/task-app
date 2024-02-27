@extends('layouts.app')

@section('title', $task->title)
@section('content')

    <p>{{$task->description}}</p>

    @if ($task->long_description)
    <p>{{$task->long_description}}</p>
    @endif

    <p>{{$task->created_at}}</p>
    <p>{{$task->updated_at}}</p>
    <p>
        @if ($task->completed)
            Completed
        @else
            Not Completed !
        @endif
    </p>

    <a href="{{route('tasks.edit', $task->id)}}">Edit</a>

    <div>
        <form action="{{
            route('tasks.complete', ['task' => $task])
        }}">
        @csrf
        @method('PUT')
            <button type="submit">
                Mark as {{ $task->completed ? 'not completed' : 'completed' }}
            </button>
        </form>
    </div>

    <form method="POST" action="{{ route('tasks.destroy', $task->id) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Task</button>
    </form>
@endsection
