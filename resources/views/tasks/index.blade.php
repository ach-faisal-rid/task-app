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
    @forelse ($paginator as $task)
    <div>
        <a href="{{ route('tasks.show', $task['id']) }}">
            {{ $task['title'] }}
        </a>
    </div>
    @empty
        <div>There are no tasks!</div>
    @endforelse

    @if ($paginator->total() > 0)
        {{ $paginator->links() }}
    @endif
</div>
@endsection
