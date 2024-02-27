@extends('layouts.app')

@section('title', 'dashboard')
@section('content')

<div>
    hello iam blade template !
</div>

@isset($name)
 <div>the name is {{ $name }}</div>
@endisset
<br>
<div>
    <!-- dd($tasks) -->
    @forelse ($tasks as $task)
        <div>
            <a href="{{ route('tasks.show', $task->id) }}">
                {{ $task->title }}
            </a>
        </div>
    @empty
        <div>There are no tasks!</div>
    @endforelse

    @if ($tasks->count())
        {{ $tasks->links() }}
    @endif
</div>
@endsection
