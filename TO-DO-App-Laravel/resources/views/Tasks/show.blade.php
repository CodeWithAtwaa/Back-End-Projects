@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h3>{{ $task->title }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Description:</strong> {{ $task->description }}</p>
            <p><strong>Status:</strong>
                @if($task->is_completed)
                    <span class="badge bg-success">Completed</span>
                @else
                    <span class="badge bg-warning">Pending</span>
                @endif
            </p>
            <a href="{{ route('home') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
