<nav class="navbar navbar-expand-md navbar-light bg-white border-bottom fixed-top py-3">
    <div class="container">
        <!-- Logo / Brand -->
        <a class="navbar-brand font-outfit fw-bold text-dark d-flex align-items-center gap-2" href="/">
            <span class="p-1.5 bg-primary text-white rounded shadow-sm d-inline-flex">
                <i class="fa-solid fa-building-user fs-6"></i>
            </span>
            <span>Kota<span class="text-primary">Hostel</span></span>
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-md-0  gap-md-2 m-auto">
                <li class="nav-item">
                    <a class="nav-link py-2 px-3 fw-medium rounded-3 {{ request()->is('hostels*') ? 'active text-primary fw-bold bg-primary-light' : 'text-secondary' }}" href="/hostels">Explore Hostels</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 px-3 fw-medium rounded-3 {{ request()->is('about') ? 'active text-primary fw-bold bg-primary-light' : 'text-secondary' }}" href="/about">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 px-3 fw-medium rounded-3 {{ request()->is('contact') ? 'active text-primary fw-bold bg-primary-light' : 'text-secondary' }}" href="/contact">Contact</a>
                </li>
            </ul>
        </div>
        <div class="d-flex align-items-center gap-3 mt-3 mt-md-0">
            @auth
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 border rounded-xl py-2 px-3" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="d-inline-flex align-items-center justify-content-center bg-primary text-white font-bold rounded-circle uppercase text-xs" style="width: 24px; height: 24px;">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </span>
                        <span class="text-dark fw-medium small">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-soft border-0 mt-2 p-2 rounded-2xl" aria-labelledby="userDropdown">
                        @if(Auth::user()->isSuperAdmin())
                            <li>
                                <a class="dropdown-item py-2 px-3 rounded-xl small fw-semibold" href="/admin">
                                    <i class="fa-solid fa-gauge-high text-muted me-2"></i> Admin Panel
                                </a>
                            </li>
                        @endif
                        <li>
                            <a class="dropdown-item py-2 px-3 rounded-xl small fw-semibold" href="{{ route('dashboard') }}">
                                <i class="fa-solid fa-square-poll-vertical text-muted me-2"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 px-3 rounded-xl small fw-semibold" href="{{ route('profile.edit') }}">
                                <i class="fa-solid fa-user text-muted me-2"></i> Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider bg-light"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 px-3 rounded-xl small fw-semibold text-danger">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i> Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-link text-decoration-none text-secondary fw-semibold">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary shadow-sm shadow-primary/10">Register</a>
            @endauth
        </div>
    </div>
</nav>
