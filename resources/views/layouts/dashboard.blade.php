<x-app-layout>
    <div class="container py-5">
        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <aside class="col-12 ">
                <div class="card border-0 shadow-soft p-4 rounded-3xl bg-white">
                    <div class="d-flex align-items-center gap-3 pb-4 mb-4 border-bottom">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white font-bold rounded-circle uppercase fs-5" style="width: 44px; height: 44px;">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <h6 class="font-outfit fw-bold text-dark mb-0">{{ Auth::user()->name }}</h6>
                            <span class="text-muted small">{{ Auth::user()->role?->name }}</span>
                        </div>
                    </div>

                    <div class="nav nav-pills gap-1">
                        @if(Auth::user()->isStudent())
                            <!-- Student Navigation -->
                            <a href="/dashboard" class="nav-link py-2.5 px-3 rounded-xl small fw-semibold d-flex align-items-center gap-2 transition-all gap-2 {{ request()->routeIs('dashboard') ? 'active bg-primary text-white shadow-sm' : 'text-secondary bg-hover-light' }}">
                                <i class="fa-solid fa-address-card"></i>
                                <span>Overview</span>
                            </a>
                            <a href="/dashboard/favorites" class="nav-link py-2.5 px-3 rounded-xl small fw-semibold d-flex align-items-center gap-2 transition-all gap-2 {{ request()->routeIs('dashboard.favorites') ? 'active bg-primary text-white shadow-sm' : 'text-secondary bg-hover-light' }}">
                                <i class="fa-solid fa-heart"></i>
                                <span>Saved Hostels</span>
                            </a>
                            <a href="/dashboard/inquiries" class="nav-link py-2.5 px-3 rounded-xl small fw-semibold d-flex align-items-center gap-2 transition-all gap-2 {{ request()->routeIs('dashboard.inquiries') ? 'active bg-primary text-white shadow-sm' : 'text-secondary bg-hover-light' }}">
                                <i class="fa-solid fa-envelope"></i>
                                <span>My Inquiries</span>
                            </a>
                            <a href="/dashboard/applications" class="nav-link py-2.5 px-3 rounded-xl small fw-semibold d-flex align-items-center gap-2 transition-all gap-2 {{ request()->routeIs('dashboard.applications') ? 'active bg-primary text-white shadow-sm' : 'text-secondary bg-hover-light' }}">
                                <i class="fa-solid fa-file-contract"></i>
                                <span>My Applications</span>
                            </a>
                            <a href="/dashboard/reviews" class="nav-link py-2.5 px-3 rounded-xl small fw-semibold d-flex align-items-center gap-2 transition-all gap-2 {{ request()->routeIs('dashboard.reviews') ? 'active bg-primary text-white shadow-sm' : 'text-secondary bg-hover-light' }}">
                                <i class="fa-solid fa-star"></i>
                                <span>My Reviews</span>
                            </a>
                        @endif

                        @if(Auth::user()->isOwner())
                            <!-- Owner Navigation -->
                            <a href="/owner" class="nav-link py-2.5 px-3 rounded-xl small fw-semibold d-flex align-items-center gap-2 transition-all gap-2 {{ request()->routeIs('owner.dashboard') ? 'active bg-primary text-white shadow-sm' : 'text-secondary bg-hover-light' }}">
                                <i class="fa-solid fa-chart-line"></i>
                                <span>Overview</span>
                            </a>
                            <a href="/owner/hostels" class="nav-link py-2.5 px-3 rounded-xl small fw-semibold d-flex align-items-center gap-2 transition-all gap-2 {{ request()->routeIs('owner.hostels*') ? 'active bg-primary text-white shadow-sm' : 'text-secondary bg-hover-light' }}">
                                <i class="fa-solid fa-hotel"></i>
                                <span>Manage Hostels</span>
                            </a>
                            <a href="/owner/inquiries" class="nav-link py-2.5 px-3 rounded-xl small fw-semibold d-flex align-items-center gap-2 transition-all gap-2 {{ request()->routeIs('owner.inquiries*') ? 'active bg-primary text-white shadow-sm' : 'text-secondary bg-hover-light' }}">
                                <i class="fa-solid fa-inbox"></i>
                                <span>Hostel Inquiries</span>
                            </a>
                            <a href="/owner/applications" class="nav-link py-2.5 px-3 rounded-xl small fw-semibold d-flex align-items-center gap-2 transition-all gap-2 {{ request()->routeIs('owner.applications*') ? 'active bg-primary text-white shadow-sm' : 'text-secondary bg-hover-light' }}">
                                <i class="fa-solid fa-file-invoice"></i>
                                <span>Hostel Applications</span>
                            </a>
                        @endif

                        <a href="/profile" class="nav-link py-2.5 px-3 rounded-xl small fw-semibold d-flex align-items-center gap-2 transition-all gap-2 {{ request()->routeIs('profile.edit') ? 'active bg-primary text-white shadow-sm' : 'text-secondary bg-hover-light' }}">
                            <i class="fa-solid fa-user-gear"></i>
                            <span>Settings</span>
                        </a>
                    </div>
                </div>
            </aside>

            <!-- Main Panel Content -->
            <div class="col-12 ">
                <div class="card border-0 shadow-soft p-4 p-md-5 rounded-3xl bg-white">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <!-- Extra style for sidebar link hover -->
    <style>
        .bg-hover-light:hover {
            background-color: rgba(var(--bs-primary-rgb), 0.03) !important;
            color: var(--bs-primary) !important;
        }
    </style>
</x-app-layout>
