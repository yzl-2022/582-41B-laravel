@extends('layouts.app')
@section('title', 'Registration')
@section('content')
    @if(!$errors->isEmpty())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>     
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>                
    @endif
    <h1 class="mt-5 mb-4">Registration</h1>
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Registration</h5>
                </div>
                <div class="card-body">
                    <form  method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="email"  value="{{old('email')}}">
                            </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection