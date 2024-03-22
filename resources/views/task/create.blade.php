@extends('layouts.app')
@section('title','Add Task')
@section('content')
    <h1 class="mt-5 mb-4">Add Task</h1>
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Add New Task</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('task.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                            @if ($errors->has('title'))
                                <div class="text-danger mt-2">
                                    {{$errors->first('title')}}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <div class="text-danger mt-2">
                                    {{$errors->first('description')}}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="completed" class="form-check-label">Completed</label>
                            <input type="checkbox" class="form-check-input" id="completed" name="completed" value="1" {{ old('completed') ? 'checked' : ''}}>
                            @if ($errors->has('completed'))
                                <div class="text-danger mt-2">
                                    {{$errors->first('completed')}}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date') }}">
                            @if ($errors->has('due_date'))
                                <div class="text-danger mt-2">
                                    {{$errors->first('due_date')}}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Task Category</label>
                            <select name="category_id" id="category_id" class="form-select">
                                <option value="">Select a Task Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category['id'] }}" @if ($category['id'] == old('category_id')) selected @endif>{{ $category['category'] }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('category_id'))
                                <div class="text-danger mt-2">
                                    {{$errors->first('category_id')}}
                                </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection