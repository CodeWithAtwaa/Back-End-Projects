<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>


    <meta charset="UTF-8">
    <link rel="shortcut icon" href="assets/img/orabi.png"
        type="image/x-icon">
    <meta name="description"
        content="System for managing department change requests in college.">
    <meta name="keywords"
        content="College, Department Change, FCI, ZU, Management System">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Change Department System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">Change Department</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    @guest
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                    @else
                    <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a href="{{ route('student.dashboard') }}" class="dropdown-item">Student Dashboard</a></li>
                            <li><a href="{{ route('student.request.create') }}" class="dropdown-item">Add Request</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                        </ul>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-5">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="text-center py-3 text-muted border-top">
        © {{ date('Y') }} - Faculty of Computers and Information
    </footer>

</body>

</html>
