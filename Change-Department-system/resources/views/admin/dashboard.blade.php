@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h3 class="mb-4">🎓 Admin Dashboard</h3>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <h5 class="mb-0">{{ session('success') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($requests->isEmpty())
            <p class="text-muted">No transfer requests found.</p>
        @else
            <table class="table table-bordered align-middle mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Current Department</th>
                        <th>Target Department</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Submitted On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $request->student->name ?? 'Unknown' }}</td>
                            <td>{{ $request->fromDepartment->name ?? 'N/A' }}</td>
                            <td>{{ $request->toDepartment->name ?? 'N/A' }}</td>
                            <td>{{ $request->reason }}</td>
                            <td>
                                @if ($request->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif ($request->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif ($request->status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>{{ $request->created_at->format('Y-m-d') }}</td>
                            <td>
                                @if ($request->status === 'pending')
                                    <form action="{{ route('admin.updateStatus', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>

                                    <form action="{{ route('admin.updateStatus', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
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
