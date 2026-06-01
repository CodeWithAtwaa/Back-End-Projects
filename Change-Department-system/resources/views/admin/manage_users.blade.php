@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h3 class="mb-4">👥 Manage Users</h3>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Add New User Form -->
        <div class="card mb-4">
            <div class="card-header">➕ Add New User</div>
            <div class="card-body">
                <form action="{{ route('admin.storeUser') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                        </div>
                        <div class="col">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="col">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <select name="role" class="form-select" required>
                            <option value="">-- Select Role --</option>
                            <option value="student">Student</option>
                            <option value="reviewer">Reviewer</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
            </div>
        </div>

        <!-- Users List -->
        <h5>All Users:</h5>
        <table class="table table-bordered mt-3 text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Actions</th> <!-- New column -->
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    <td>
                        @if(Auth::id() !== $user->id && $user->role !== 'admin') <!-- cannot delete self or other admins -->
                        <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection
