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

            <!-- Stat card 6: Average Trust Score (Feature 5) -->
            <div class="col-12 col-sm-6 col-md-4 col-lg">
                <div class="card h-100 border-0 p-4 rounded-3xl d-flex flex-row align-items-center gap-3 shadow-sm bg-opacity-10 border hover-shadow transition-all duration-300" style="background-color: rgba(111, 66, 193, 0.08); border-color: rgba(111, 66, 193, 0.1);">
                    <div class="d-inline-flex p-3 text-white rounded-xl shadow-sm" style="background-color: #6f42c1;">
                        <i class="fa-solid fa-ranking-star fs-4"></i>
                    </div>
                    <div>
                        <span class="text-uppercase text-muted fw-bold small d-block" style="font-size: 10px;">Avg Trust Score</span>
                        <h4 class="font-outfit fw-bold text-dark mt-1 mb-0">{{ $avgScore }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Widgets Section (Feature 5) -->
        <div class="row g-4 mt-1 mb-2">
            <!-- Widget 1: Top Listings Performance -->
            <div class="col-12 col-md-6">
                <div class="card border border-light-subtle shadow-soft p-4 rounded-3xl bg-white h-100">
                    <h6 class="font-outfit fw-bold text-dark mb-4 border-bottom pb-2.5"><i class="fa-solid fa-star text-warning me-2"></i>Top Listings Performance</h6>
                    
                    <div class="d-flex flex-column gap-3">
                        <!-- Most Viewed -->
                        <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-xl">
                           <div class="d-flex align-items-center gap-3">
                               <div class="d-inline-flex p-2 bg-info text-white rounded-lg" style="padding: 6px 10px !important;"><i class="fa-solid fa-eye text-white fs-6"></i></div>
                               <div>
                                   <strong class="text-dark small d-block" style="font-size: 12.5px;">Most Viewed Hostel</strong>
                                   <span class="text-secondary small" style="font-size: 11.5px;">{{ $mostViewedHostel ? $mostViewedHostel->title : 'N/A' }}</span>
                               </div>
                           </div>
                           <span class="badge bg-info text-white fw-bold px-2.5 py-1.5" style="font-size: 10px;">{{ $mostViewedHostel ? number_format($mostViewedHostel->views) . ' views' : '0' }}</span>
                        </div>

                        <!-- Best Performing -->
                        <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-xl">
                           <div class="d-flex align-items-center gap-3">
                               <div class="d-inline-flex p-2 bg-primary text-white rounded-lg" style="padding: 6px 10px !important;"><i class="fa-solid fa-ranking-star text-white fs-6"></i></div>
                               <div>
                                   <strong class="text-dark small d-block" style="font-size: 12.5px;">Best Performing Hostel</strong>
                                   <span class="text-secondary small" style="font-size: 11.5px;">{{ $bestPerformingHostel ? $bestPerformingHostel->title : 'N/A' }}</span>
                               </div>
                           </div>
                           <span class="badge bg-primary text-white fw-bold px-2.5 py-1.5" style="font-size: 10px;">{{ $bestPerformingHostel ? 'Score: ' . $bestPerformingHostel->hostel_score : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Widget 2: Inquiry Growth & Traffic -->
            <div class="col-12 col-md-6">
                <div class="card border border-light-subtle shadow-soft p-4 rounded-3xl bg-white h-100">
                    <h6 class="font-outfit fw-bold text-dark mb-4 border-bottom pb-2.5"><i class="fa-solid fa-chart-line text-success me-2"></i>Monthly Traffic & Growth</h6>
                    
                    <div class="row g-3">
                        <div class="col-6 text-center border-end">
                            <span class="text-muted text-uppercase fw-bold small d-block" style="font-size: 9px; letter-spacing: 0.5px;">Inquiries (This Mo / Last)</span>
                            <h3 class="font-outfit fw-bold text-dark mt-2 mb-0" style="font-size: 1.6rem;">{{ $inquiriesThisMonth }} <span class="fs-6 text-muted fw-normal">/ {{ $inquiriesLastMonth }}</span></h3>
                            
                            @if($inquiryGrowth >= 0)
                                <span class="text-success small fw-bold mt-2 d-inline-flex align-items-center gap-1" style="font-size: 11px;"><i class="fa-solid fa-circle-arrow-up"></i> +{{ $inquiryGrowth }}% growth</span>
                            @else
                                <span class="text-danger small fw-bold mt-2 d-inline-flex align-items-center gap-1" style="font-size: 11px;"><i class="fa-solid fa-circle-arrow-down"></i> {{ $inquiryGrowth }}% decline</span>
                            @endif
                        </div>

                        <div class="col-6 text-center">
                            <span class="text-muted text-uppercase fw-bold small d-block" style="font-size: 9px; letter-spacing: 0.5px;">Applications (This Mo / Last)</span>
                            <h3 class="font-outfit fw-bold text-dark mt-2 mb-0" style="font-size: 1.6rem;">{{ $appsThisMonth }} <span class="fs-6 text-muted fw-normal">/ {{ $appsLastMonth }}</span></h3>
                            
                            @php
                                $appGrowth = $appsLastMonth > 0 
                                    ? round((($appsThisMonth - $appsLastMonth) / $appsLastMonth) * 100, 1)
                                    : ($appsThisMonth > 0 ? 100.0 : 0.0);
                            @endphp
                            @if($appGrowth >= 0)
                                <span class="text-success small fw-bold mt-2 d-inline-flex align-items-center gap-1" style="font-size: 11px;"><i class="fa-solid fa-circle-arrow-up"></i> +{{ $appGrowth }}% growth</span>
                            @else
                                <span class="text-danger small fw-bold mt-2 d-inline-flex align-items-center gap-1" style="font-size: 11px;"><i class="fa-solid fa-circle-arrow-down"></i> {{ $appGrowth }}% decline</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Property Rankings List (Feature 5) -->
        <div class="border-top border-light-subtle pt-4 mb-2">
            <h5 class="font-outfit fw-bold text-dark mb-4">Property Rankings & Scores</h5>
            
            @if($myHostels->count() > 0)
                <div class="table-responsive bg-white rounded-4 border border-light-subtle shadow-sm overflow-hidden">
                    <table class="table align-middle text-sm text-secondary mb-0">
                        <thead class="table-light text-uppercase text-dark font-semibold">
                            <tr>
                                <th class="px-4 py-3" style="font-size: 11px; letter-spacing: 0.5px;">Hostel</th>
                                <th class="px-4 py-3" style="font-size: 11px; letter-spacing: 0.5px;">Area</th>
                                <th class="px-4 py-3 text-center" style="font-size: 11px; letter-spacing: 0.5px;">Views</th>
                                <th class="px-4 py-3 text-center" style="font-size: 11px; letter-spacing: 0.5px;">Trust Score</th>
                                <th class="px-4 py-3 text-center" style="font-size: 11px; letter-spacing: 0.5px;">Rank in Kota</th>
                                <th class="px-4 py-3 text-center" style="font-size: 11px; letter-spacing: 0.5px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($myHostels as $h)
                                <tr class="hover-bg-light transition-colors">
                                    <td class="px-4 py-3 fw-bold text-dark border-0">
                                        <div class="d-flex align-items-center gap-2">
                                            @if($h->primary_image)
                                                <img src="{{ $h->primary_image }}" alt="" class="rounded" style="width: 36px; height: 28px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center text-primary rounded" style="width: 36px; height: 28px;">
                                                    <i class="fa-solid fa-building text-xs"></i>
                                                </div>
                                            @endif
                                            <span>{{ $h->title }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 border-0">{{ $h->area->title }}</td>
                                    <td class="px-4 py-3 text-center border-0 fw-semibold">{{ number_format($h->views) }}</td>
                                    <td class="px-4 py-3 text-center border-0">
                                        <span class="badge bg-primary text-white fw-bold px-2.5 py-1" style="font-size: 11.5px;">{{ $h->hostel_score }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-center border-0 fw-bold text-dark">
                                        <span class="badge bg-success bg-opacity-10 text-success px-2.5 py-1.5 rounded" style="font-size: 11px;">#{{ $h->kota_rank }}</span>
                                    </td>
                                    <td class="px-4 py-3 border-0">
                                        <a href="/hostels/{{ $h->area->slug }}/{{ $h->slug }}" class="btn btn-outline-primary btn-xs py-1 px-2.5 rounded text-xs fw-bold" style="font-size: 10px;">View Page</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-light border border-dashed rounded-3xl text-center py-4">
                    <p class="text-secondary small mb-0">No hostels listed yet.</p>
                </div>
            @endif
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
                                <th class="px-4 py-3  ">Hostel</th>
                                <th class="px-4 py-3 border-0">Inquirer Name</th>
                                <th class="px-4 py-3 border-0">Mobile</th>
                                <th class="px-4 py-3 border-0">Message</th>
                                <th class="px-4 py-3  ">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentInquiries as $inquiry)
                                <tr class="hover-bg-light transition-colors">
                                    <td class="px-4 py-3 fw-bold text-dark border-0">{{ $inquiry->hostel->title }}</td>
                                    <td class="px-4 py-3  text-muted">{{ $inquiry->name }}</td>
                                    <td class="px-4 py-3  text-muted">{{ $inquiry->mobile }}</td>
                                    <td class="px-4 py-3  text-muted text-truncate" style="max-width: 150px; display: inline-block; overflow: hidden; white-space: nowrap;">{{ $inquiry->message }}</td>
                                    <td class="px-4 py-3  text-muted">{{ $inquiry->created_at->format('d M Y') }}</td>
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
