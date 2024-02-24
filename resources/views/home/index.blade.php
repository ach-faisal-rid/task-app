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
    <!--dd($tasks)-->
    @if (is_array($tasks) && count($tasks))
        @foreach ($tasks as $task)
            <div>
                <a href="{{route('tasks.show',
                    ['id' => $task->id])}}"
                >
                    {{$task->title}}
            </a>
            </div>
        @endforeach()
    @else
        <div>There are no tasks!</div>
    @endif
</div>
@endsection
