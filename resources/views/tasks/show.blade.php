@extends('layouts.app')

@section('title', $task->title)
@section('content')

    <p>{{$task->description}}</p>

    @if ($task->long_description)
    <p>{{$task->long_description}}</p>
    @endif

    <p>{{$task->created_at}}</p>
    <p>{{$task->updated_at}}</p>

    <a href="{{route('tasks.edit', $task->id)}}">Edit</a>

    <form method="POST" action="{{ route('tasks.destroy', $task->id) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Task</button>
    </form>
@endsection
