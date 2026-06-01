@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                <h1 class="text-center text-white">TO-DO List <span class="btn btn-primary">{{ $tasks->count() }}</span>
                </h1>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                       {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card m-auto">
                    <div class="card-body">
                        <a class="btn btn-success mb-2" href="{{ route('task.create') }}">Create New</a>
                        <div class="table-responsive">
                            <table
                                class="table table-dark text-center table-active  table-sm table-striped table-bordere table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Complete</th>
                                        <th>Operations</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td>{{ $task->id }}</td>
                                            <td>{{ $task->title }}</td>
                                            <td>{{ $task->description }}</td>
                                            <td><input type="checkbox" class="form-check-input toggle-complete"
                                                    data-id="{{ $task->id }}" {{ $task->is_completed ? 'checked' : '' }}></td>
                                            <td>
                                                <a class="btn btn-primary" href="{{ route('task.show', $task->id) }}"><i
                                                        class="fas fa-eye"></i></a>
                                                <a class="btn btn-warning" href="{{ route('task.edit', $task->id) }}"><i class="fas fa-pen"></i></a>

                                                <form action="{{ route('task.destroy', $task->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Are you sure delete this Task?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const checkboxes = document.querySelectorAll('.toggle-complete');

            checkboxes.forEach(chk => {
                chk.addEventListener("change", function () {
                    const taskId = chk.dataset.id;
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(`/tasks/${taskId}/toggle`, {
                        method: "PATCH",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": token
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                const row = chk.closest('tr');
                                if (data.completed) {
                                    row.classList.add('completed');
                                } else {
                                    row.classList.remove('completed');
                                }
                            }
                        })
                        .catch(err => console.error(err));
                });
            });
        });
    </script>


    <style>
        .completed td {
            text-decoration: line-through;
            color: gray;
        }
    </style>
@endsection



<!-- <li class="nav-item"><a href="{{ to_route('home') }}" class="nav-link">Home</a></li> -->
