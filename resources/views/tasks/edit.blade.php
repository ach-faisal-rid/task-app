@extends('layouts.app')

@section('content')
@include('tasks.form', ['task' => $task])
@endsection
