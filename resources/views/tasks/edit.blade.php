@extends('layouts.app')

@section('title', 'Edit Task')

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

<form method="POST" action="{{ route('tasks.update', $task->id) }}">

    @method('PUT')
    @csrf

    <div>
        <label for="title">
            Title
        </label>
        <input type="text" name="title" id="title" value="{{ $task->title }}" />
    </div>

    <div>
        <label for="description">Description</label>
        <textarea name="description" id="description" rows="5">{{ $task->description }}</textarea>
    </div>

    <div>
        <label for="long_description">Long Description</label>
        <textarea name="long_description" id="long_description" rows="10">{{ $task->long_description }}</textarea>
    </div>

    <div>
        <button type="submit">Update Task</button>
    </div>
</form>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@endsection
