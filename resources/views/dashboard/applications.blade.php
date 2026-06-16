<x-layouts.dashboard>
    <div class="d-flex flex-column gap-4">
        <div>
            <h2 class="font-outfit fs-3 fw-bold text-dark mb-1">My Applications</h2>
            <p class="text-secondary small">Track status of your admissions requests submitted to hostels.</p>
        </div>

        @if($applications->count() > 0)
            <div class="d-flex flex-column gap-3">
                @foreach($applications as $application)
                    <div class="card border border-light-subtle rounded-2xl p-4 hover-shadow transition-all bg-white">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <h5 class="font-outfit fw-bold text-dark mb-0">
                                        <a href="/hostels/{{ $application->hostel->area->slug }}/{{ $application->hostel->slug }}" class="text-decoration-none text-dark hover-color-primary">
                                            {{ $application->hostel->title }}
                                        </a>
                                    </h5>
                                    <span class="badge px-2.5 py-1 rounded-pill text-xs fw-bold
                                        {{ $application->status === 'pending' ? 'bg-warning text-dark' : '' }}
                                        {{ $application->status === 'approved' ? 'bg-success text-white' : '' }}
                                        {{ $application->status === 'rejected' ? 'bg-danger text-white' : '' }}
                                        {{ $application->status === 'cancelled' ? 'bg-secondary text-white' : '' }}
                                    ">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </div>
                                @if($application->notes)
                                    <p class="text-muted small mb-1 italic">"{{ $application->notes }}"</p>
                                @endif
                                <div class="text-muted text-xs d-flex align-items-center gap-3 flex-wrap" style="font-size: 11px;">
                                    <span><i class="fa-solid fa-location-dot me-1 text-muted"></i> Area: {{ $application->hostel->area->title }}</span>
                                    <span><i class="fa-regular fa-calendar me-1"></i> Joining: {{ $application->joining_date->format('d M Y') }}</span>
                                    <span><i class="fa-regular fa-clock me-1"></i> Applied: {{ $application->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                            <div class="ms-md-auto">
                                <a href="/hostels/{{ $application->hostel->area->slug }}/{{ $application->hostel->slug }}" class="btn btn-outline-secondary btn-sm px-3 rounded-pill text-xs">
                                    View Hostel
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 border border-dashed rounded-3xl bg-light bg-opacity-25">
                <div class="text-muted opacity-25 mb-4">
                    <i class="fa-solid fa-file-invoice display-4"></i>
                </div>
                <h4 class="font-outfit fw-bold text-dark">No applications found</h4>
                <p class="text-secondary small max-w-sm mx-auto my-2">You haven't submitted any booking applications yet. Browse hostels and apply from details pages.</p>
                <a href="/hostels" class="btn btn-primary mt-3 px-4 rounded-pill">
                    Find Accommodations
                </a>
            </div>
        @endif
    </div>

    <style>
        .hover-shadow:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
        }
        .hover-color-primary:hover {
            color: var(--bs-primary) !important;
        }
        .italic {
            font-style: italic;
        }
    </style>
</x-layouts.dashboard>
