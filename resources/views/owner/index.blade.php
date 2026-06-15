<x-layouts.dashboard>
    <div class="d-flex flex-column gap-4">
        <div>
            <h2 class="font-outfit fs-3 fw-bold text-dark mb-1">Owner Dashboard</h2>
            <p class="text-secondary small">Real-time performance metrics for your hostel properties in Kota.</p>
        </div>

        <!-- Stats Grid -->
        <div class="row g-4 mb-2">
            <!-- Stat card 1: Hostels -->
            <div class="col-12 col-sm-6 col-md-4 col-lg">
                <div class="card h-100 border-0 p-4 rounded-3xl d-flex flex-row align-items-center gap-3 shadow-sm bg-primary bg-opacity-10 border border-primary border-opacity-10 hover-shadow transition-all duration-300">
                    <div class="d-inline-flex p-3 bg-primary text-white rounded-xl shadow-sm">
                        <i class="fa-solid fa-hotel fs-4"></i>
                    </div>
                    <div>
                        <span class="text-uppercase text-muted fw-bold small d-block" style="font-size: 10px;">My Hostels</span>
                        <h4 class="font-outfit fw-bold text-dark mt-1 mb-0">{{ $totalHostels }}</h4>
                    </div>
                </div>
            </div>

            <!-- Stat card 2: Inquiries -->
            <div class="col-12 col-sm-6 col-md-4 col-lg">
                <div class="card h-100 border-0 p-4 rounded-3xl d-flex flex-row align-items-center gap-3 shadow-sm bg-success bg-opacity-10 border border-success border-opacity-10 hover-shadow transition-all duration-300">
                    <div class="d-inline-flex p-3 bg-success text-white rounded-xl shadow-sm">
                        <i class="fa-solid fa-envelope fs-4"></i>
                    </div>
                    <div>
                        <span class="text-uppercase text-muted fw-bold small d-block" style="font-size: 10px;">Inquiries</span>
                        <h4 class="font-outfit fw-bold text-dark mt-1 mb-0">{{ $totalInquiries }}</h4>
                    </div>
                </div>
            </div>

            <!-- Stat card 3: Applications -->
            <div class="col-12 col-sm-6 col-md-4 col-lg">
                <div class="card h-100 border-0 p-4 rounded-3xl d-flex flex-row align-items-center gap-3 shadow-sm bg-warning bg-opacity-10 border border-warning border-opacity-10 hover-shadow transition-all duration-300">
                    <div class="d-inline-flex p-3 bg-warning text-dark rounded-xl shadow-sm">
                        <i class="fa-solid fa-file-invoice fs-4" style="color: #664d03;"></i>
                    </div>
                    <div>
                        <span class="text-uppercase text-muted fw-bold small d-block" style="font-size: 10px;">Applications</span>
                        <h4 class="font-outfit fw-bold text-dark mt-1 mb-0">{{ $totalApplications }}</h4>
                    </div>
                </div>
            </div>

            <!-- Stat card 4: Views -->
            <div class="col-12 col-sm-6 col-md-4 col-lg">
                <div class="card h-100 border-0 p-4 rounded-3xl d-flex flex-row align-items-center gap-3 shadow-sm bg-info bg-opacity-10 border border-info border-opacity-10 hover-shadow transition-all duration-300">
                    <div class="d-inline-flex p-3 bg-info text-white rounded-xl shadow-sm">
                        <i class="fa-solid fa-eye fs-4"></i>
                    </div>
                    <div>
                        <span class="text-uppercase text-muted fw-bold small d-block" style="font-size: 10px;">Total Views</span>
                        <h4 class="font-outfit fw-bold text-dark mt-1 mb-0">{{ $totalViews }}</h4>
                    </div>
                </div>
            </div>

            <!-- Stat card 5: Favorite Count -->
            <div class="col-12 col-sm-6 col-md-4 col-lg">
                <div class="card h-100 border-0 p-4 rounded-3xl d-flex flex-row align-items-center gap-3 shadow-sm bg-danger bg-opacity-10 border border-danger border-opacity-10 hover-shadow transition-all duration-300">
                    <div class="d-inline-flex p-3 bg-danger text-white rounded-xl shadow-sm">
                        <i class="fa-solid fa-heart fs-4"></i>
                    </div>
                    <div>
                        <span class="text-uppercase text-muted fw-bold small d-block" style="font-size: 10px;">Shortlists</span>
                        <h4 class="font-outfit fw-bold text-dark mt-1 mb-0">{{ $favoriteCount }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Inquiries Section -->
        <div class="border-top border-light-subtle pt-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="font-outfit fw-bold text-dark mb-0">Recent Inquiries</h5>
                <a href="/owner/inquiries" class="text-xs font-bold text-primary text-decoration-none hover:underline">View All</a>
            </div>
            
            @if($recentInquiries->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle text-sm text-secondary mb-0">
                        <thead class="table-light text-uppercase text-dark font-semibold">
                            <tr>
                                <th class="px-4 py-3 border-0 rounded-start-pill">Hostel</th>
                                <th class="px-4 py-3 border-0">Inquirer Name</th>
                                <th class="px-4 py-3 border-0">Mobile</th>
                                <th class="px-4 py-3 border-0">Message</th>
                                <th class="px-4 py-3 border-0 rounded-end-pill">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentInquiries as $inquiry)
                                <tr class="hover-bg-light transition-colors">
                                    <td class="px-4 py-3 fw-bold text-dark border-0">{{ $inquiry->hostel->title }}</td>
                                    <td class="px-4 py-3 border-0 text-muted">{{ $inquiry->name }}</td>
                                    <td class="px-4 py-3 border-0 text-muted">{{ $inquiry->mobile }}</td>
                                    <td class="px-4 py-3 border-0 text-muted text-truncate" style="max-width: 150px; display: inline-block; overflow: hidden; white-space: nowrap;">{{ $inquiry->message }}</td>
                                    <td class="px-4 py-3 border-0 text-muted">{{ $inquiry->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-light border border-dashed rounded-3xl text-center py-5">
                    <div class="text-muted opacity-25 mb-3">
                        <i class="fa-solid fa-envelope-open-text display-5"></i>
                    </div>
                    <p class="text-secondary small mb-0">No inquiries received yet.</p>
                </div>
            @endif
        </div>
    </div>

    <style>
        .hover-shadow:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
        }
        .hover-bg-light:hover {
            background-color: #fafafb !important;
        }
        .transition-colors {
            transition: background-color 0.2s ease;
        }
    </style>
</x-layouts.dashboard>
