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
            <div>{{$task->title}}</div>
        @endforeach()
    @else
        <div>There are no tasks!</div>
    @endif
</div>
