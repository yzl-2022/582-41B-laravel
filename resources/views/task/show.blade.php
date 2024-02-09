@extends('layouts.app')
@section('title', 'Task')
@section('content')
    <h1 class="mt-5 mb-4">Task</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-5">
                <div class="card-header">
                    <h5 class="card-title">{{ $task->title }}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $task->description }}</p>
                    <ul class="list-unstyled">
                        <li><strong>Completed:</strong> {{ $task->completed ? 'Yes' : 'No' }}</li>
                        <li><strong>Due Date:</strong> {{ $task->due_date }}</li>
                        <li><strong>Author:</strong> {{ $task->author }}</li>
                    </ul>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="#" class="btn btn-sm btn-outline-success">Edit</a>
                    <a href="#" class="btn btn-sm btn-outline-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
@endsection