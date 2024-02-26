@extends('layouts.app')

@section('title', isset($task) ? 'edit task' : 'Add Task')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="
    {{
        isset($task) ?
        route('tasks.update', ['task' => $task->id]) :
        route('tasks.store')
    }}"
    >
    @csrf

    @isset($task)
        @method('PUT')
    @endisset

    <div>
        <label for="title">
            Title
        </label>
        <input type="text" name="title" id="title"
        value="{{ $task->title ?? old('title') }}" />
    </div>

    <div>
        <label for="description">Description</label>
        <textarea name="description" id="description" rows="5">
        {{  $task->description ?? old('description') }}
    </textarea>
    </div>

    <div>
        <label for="long_description">Long Description</label>
        <textarea name="long_description" id="long_description"
        rows="10"
        >
            {{ $task->long_description ?? old('long_description') }}
        </textarea>
    </div>

    <div>
        <button type="submit">
            @isset($task)
                Update Task
                @else
                Add Task
            @endisset
        </button>
    </div>
</form>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@endsection
