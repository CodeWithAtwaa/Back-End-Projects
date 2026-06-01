@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 m-auto">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-center">Create A New Task</h1>
                        <form action="{{ route('task.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="title" placeholder="Enter Your Title" class="form-control mt-5" value="{{ old('title') }}">
                            @error('title')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                            <input type="text" name="description" placeholder="Enter Your Description"
                                class="form-control mt-5" value="{{ old('description') }}">
                            @error('description')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                            <input type="submit" value="Create" class="form-control mt-5 btn btn-success">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
