<x-layouts.dashboard>
    <div class="d-flex flex-column gap-4">
        <div>
            <h2 class="font-outfit fs-3 fw-bold text-dark mb-1">Saved Hostels</h2>
            <p class="text-secondary small">Accommodations you have shortlisted.</p>
        </div>

        @if($favorites->count() > 0)
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach($favorites as $hostel)
                    <div class="col">
                        <div class="card h-100 border border-light-subtle rounded-2xl overflow-hidden shadow-soft hover-shadow transition-all bg-white position-relative group">
                            <!-- Gender Badge -->
                            <span class="position-absolute top-0 start-0 m-3 z-3 badge px-2.5 py-1.5 text-uppercase font-semibold tracking-wide rounded-3
                                {{ $hostel->gender_type === 'boys' ? 'bg-primary text-white' : '' }}
                                {{ $hostel->gender_type === 'girls' ? 'bg-danger text-white' : '' }}
                                {{ $hostel->gender_type === 'coed' ? 'bg-success text-white' : '' }}
                            " style="font-size: 11px;">
                                {{ $hostel->gender_type }}
                            </span>

                            <!-- Image Section -->
                            <div class="position-relative overflow-hidden bg-light" style="height: 180px;">
                                @if($hostel->images->first())
                                    <img src="{{ $hostel->images->first()->getUrl() }}" alt="{{ $hostel->title }}" class="w-100 h-100 object-cover transition-transform duration-300 img-hover-zoom">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted opacity-25">
                                        <i class="fa-solid fa-hotel display-5"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Details -->
                            <div class="card-body p-4 d-flex flex-column justify-content-between">
                                <div class="mb-3">
                                    <div class="d-flex align-items-center gap-1.5 text-muted small fw-semibold mb-2">
                                        <i class="fa-solid fa-location-dot text-secondary"></i>
                                        <span>{{ $hostel->area->title }}</span>
                                    </div>

                                    <h5 class="font-outfit fw-bold text-dark mb-0">
                                        <a href="/hostels/{{ $hostel->area->slug }}/{{ $hostel->slug }}" class="text-decoration-none text-dark hover-color-primary">
                                            {{ $hostel->title }}
                                        </a>
                                    </h5>
                                </div>

                                <div class="d-flex align-items-center justify-content-between border-top border-light-subtle pt-3 mt-auto">
                                    <div>
                                        <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 10px;">Monthly Rent</span>
                                        <span class="fs-5 fw-extrabold text-primary font-outfit">₹{{ number_format($hostel->monthly_rent) }}</span>
                                    </div>
                                    <a href="/hostels/{{ $hostel->area->slug }}/{{ $hostel->slug }}" class="btn btn-primary btn-sm px-3 rounded-pill text-xs">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 border border-dashed rounded-3xl bg-light bg-opacity-25">
                <div class="text-muted opacity-25 mb-4">
                    <i class="fa-solid fa-heart-crack display-4"></i>
                </div>
                <h4 class="font-outfit fw-bold text-dark">No saved hostels</h4>
                <p class="text-secondary small max-w-sm mx-auto my-2">Browse hostels and tap the heart icon to save them.</p>
                <a href="/hostels" class="btn btn-primary mt-3 px-4 rounded-pill">
                    Find a Hostel
                </a>
            </div>
        @endif
    </div>

    <style>
        .hover-shadow:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
        }
        .img-hover-zoom {
            transition: transform .3s ease-in-out;
        }
        .img-hover-zoom:hover {
            transform: scale(1.05);
        }
        .hover-color-primary:hover {
            color: var(--bs-primary) !important;
        }
    </style>
</x-layouts.dashboard>
