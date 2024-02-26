@extends('layouts.app')

@section('title', 'Add Task')

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

<form method="POST" action="{{ route('tasks.store') }}">
    @csrf

    <div>
        <label for="title">
            Title
        </label>
        <input type="text" name="title" id="title" value="{{ old('title') }}" />
    </div>

    <div>
        <label for="description">Description</label>
        <textarea name="description" id="description" rows="5">{{ old('description') }}</textarea>
    </div>

    <div>
        <label for="long_description">Long Description</label>
        <textarea name="long_description" id="long_description" rows="10">{{ old('description') }}</textarea>
    </div>

    <div>
        <button type="submit">Add Task</button>
    </div>
</form>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@endsection
