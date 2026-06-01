<!--===================== start navbar =====================-->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand ms-5" href="#">FCI ZU</a>
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#department">Departments</a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav me-5">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            @if(Auth::user()->role === 'student')
                                <a href="{{ route('student.dashboard') }}" class="dropdown-item">Student Dashboard</a>
                            @elseif(Auth::user()->role === 'reviewer')
                                <a href="{{ route('reviewer.dashboard') }}" class="dropdown-item">Reviewer Dashboard</a>
                            @elseif(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item">Admin Dashboard</a>
                                <a href="{{ route('admin.manageUsers') }}" class="dropdown-item">Manage Users</a>
                            @endif

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<!--===================== end navbar =====================-->
