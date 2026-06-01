@extends('layouts.app')

@section('title', 'Submit Transfer Request')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h3 class="mb-4">📝 Submit a New Transfer Request</h3>

        <form action="{{ route('student.request.store') }}" method="POST">
            @csrf

            <!-- Current Department -->
            <div class="mb-3">
                <label class="form-label">Current Department</label>
                <select name="from_department" class="form-select" required>
                    <option value="">-- Select Current Department --</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" {{ old('from_department') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
                @error('from_department')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Target Department -->
            <div class="mb-3">
                <label class="form-label">Target Department</label>
                <select name="to_department" class="form-select" required>
                    <option value="">-- Select Target Department --</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" {{ old('to_department') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
                @error('to_department')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Reason -->
            <div class="mb-3">
                <label class="form-label">Reason for Transfer</label>
                <textarea name="reason" class="form-control" rows="3" required>{{ old('reason') }}</textarea>
                @error('reason')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit Request</button>
        </form>
    </div>
</div>
@endsection
