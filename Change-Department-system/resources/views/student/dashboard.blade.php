@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h3 class="mb-4">Welcome, {{ $studentName ?? Auth::user()->name }} 👋</h3>

        <a href="{{ route('student.request.create') }}" class="btn btn-success mb-3">
            ➕ Submit New Transfer Request
        </a>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <h5 class="mb-0">{{ session('success') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h5>Previous Transfer Requests:</h5>

        @if ($requests->isEmpty())
            <p class="text-muted mt-3">You haven’t submitted any transfer requests yet.</p>
        @else
            <table class="table table-bordered mt-3 align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>Current Department</th>
                        <th>Target Department</th>
                        <th>Status</th>
                        <th>Submission Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                        <tr>
                            <td>{{ $request->fromDepartment->name ?? 'N/A' }}</td>
                            <td>{{ $request->toDepartment->name ?? 'N/A' }}</td>
                            <td>
                                @if ($request->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending Review</span>
                                @elseif ($request->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif ($request->status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>{{ $request->created_at->format('Y-m-d') }}</td>
                            <td>
                                @if ($request->status === 'pending')
                                    <!-- Delete Button -->
                                    <form action="{{ route('student.request.destroy', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this request?')">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">No actions</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
