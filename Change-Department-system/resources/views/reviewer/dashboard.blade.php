@extends('layouts.app')

@section('title', 'Reviewer Dashboard')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h3 class="mb-4">📋 Transfer Requests Review</h3>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <h5 class="mb-0">{{ session('success') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <h5 class="mb-0">{{ session('error') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($requests->isEmpty())
            <p class="text-muted mt-3">No transfer requests found.</p>
        @else
            <table class="table table-bordered mt-3 align-middle">
                <thead class="table-primary">
                    <tr class="text-center">
                        <th>Student</th>
                        <th>From Department</th>
                        <th>To Department</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Submitted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                        <tr class="text-center">
                            <td>{{ $request->student->name ?? 'N/A' }}</td>
                            <td>{{ $request->fromDepartment->name ?? 'N/A' }}</td>
                            <td>{{ $request->toDepartment->name ?? 'N/A' }}</td>
                            <td>{{ $request->reason }}</td>
                            <td>
                                @if ($request->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif ($request->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif ($request->status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>{{ $request->created_at->format('Y-m-d') }}</td>
                            <td>
                                @if ($request->status === 'pending')
                                    <form action="{{ route('reviewer.approve', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">✅ Approve</button>
                                    </form>
                                    <form action="{{ route('reviewer.reject', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">❌ Reject</button>
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
