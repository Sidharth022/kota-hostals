<x-app-layout>
    <!-- Map Leaflet CSS -->
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    @endpush

    <div class="container py-4">
        <!-- Breadcrumb & Top Bar -->
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-primary fw-medium">Home</a></li>
                    <li class="breadcrumb-item"><a href="/hostels" class="text-decoration-none text-primary fw-medium">Hostels</a></li>
                    <li class="breadcrumb-item"><a href="/hostels?area={{ $hostel->area->slug }}" class="text-decoration-none text-primary fw-medium">{{ $hostel->area->title }}</a></li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">{{ $hostel->title }}</li>
                </ol>
            </nav>

            <div class="d-flex align-items-center gap-2">
                <!-- Save Button -->
                <livewire:favorite-button :hostelId="$hostel->id" />
            </div>
        </div>

        <!-- Hostel Title Header -->
        <div class="mb-4">
            <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                <span class="badge uppercase tracking-wide px-2.5 py-1.5 fw-bold shadow-sm
                    {{ $hostel->gender_type === 'boys' ? 'bg-primary text-white' : '' }}
                    {{ $hostel->gender_type === 'girls' ? 'bg-danger text-white' : '' }}
                    {{ $hostel->gender_type === 'coed' ? 'bg-success text-white' : '' }}
                ">
                    {{ $hostel->gender_type }} Accommodation
                </span>
                @if($hostel->verified)
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2.5 py-1.5 rounded-pill fw-bold d-inline-flex align-items-center gap-1">
                        <i class="fa-solid fa-circle-check fs-6"></i> Verified Property
                    </span>
                @endif
            </div>
            
            <h1 class="font-outfit fw-extrabold text-dark tracking-tight leading-tight display-6 mb-2">{{ $hostel->title }}</h1>
            
            <p class="text-secondary small d-flex align-items-center gap-2 fw-medium mb-0">
                <i class="fa-solid fa-location-dot text-muted"></i>
                <span>{{ $hostel->address }}, {{ $hostel->area->title }}, Kota</span>
            </p>
        </div>

        <!-- GALLERY IMAGES -->
        <div class="row g-3 mb-4" style="height: 400px;">
            @php
                $images = $hostel->images;
            @endphp
            @if($images->count() > 0)
                <!-- Main Large Image -->
                <div class="col-12 col-md-8 h-100">
                    <div class="card h-100 border-0 rounded-3xl overflow-hidden shadow-soft">
                        <img src="{{ $images[0]->getUrl() }}" alt="" class="w-100 h-100 object-fit-cover hover-scale-img transition-transform duration-500">
                    </div>
                </div>
                <!-- Small side images -->
                <div class="col-4 d-none d-md-block h-100">
                    <div class="row g-3 h-100">
                        @for($i = 1; $i < min($images->count(), 3); $i++)
                            <div class="col-12 h-50">
                                <div class="card h-100 border-0 rounded-3xl overflow-hidden shadow-soft">
                                    <img src="{{ $images[$i]->getUrl() }}" alt="" class="w-100 h-100 object-fit-cover hover-scale-img transition-transform duration-500">
                                </div>
                            </div>
                        @endfor
                        @if($images->count() < 3)
                            @for($j = $images->count(); $j < 3; $j++)
                                <div class="col-12 h-50">
                                    <div class="card h-100 border-0 rounded-3xl bg-light d-flex align-items-center justify-content-center text-secondary opacity-25">
                                        <i class="fa-solid fa-image fs-3"></i>
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
                </div>
            @else
                <!-- Gradient Placeholder -->
                <div class="col-12 h-100">
                    <div class="card h-100 border-0 rounded-3xl bg-light d-flex flex-column align-items-center justify-content-center text-secondary opacity-50 py-5">
                        <i class="fa-solid fa-images display-3 mb-3 text-muted"></i>
                        <h6 class="font-outfit fw-bold text-dark">No images uploaded yet</h6>
                        <p class="text-muted small mb-0">Images of the hostel room will appear here.</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- MAIN LAYOUT (CONTENT VS SIDEBAR) -->
        <div class="row g-4 align-items-start">
            <!-- Left Column: Details -->
            <div class="col-12 col-lg-8">
                <!-- Description -->
                <div class="card border-0 shadow-soft p-4 rounded-3xl bg-white mb-4">
                    <h5 class="font-outfit fw-bold text-dark mb-3">About Accommodation</h5>
                    <div class="text-secondary small leading-relaxed">
                        {!! $hostel->description !!}
                    </div>
                </div>

                <!-- Room Types & Rent details -->
                <div class="card border-0 shadow-soft p-4 rounded-3xl bg-white mb-4">
                    <h5 class="font-outfit fw-bold text-dark mb-4">Pricing & Availability</h5>
                    <div class="row g-4 align-items-end">
                        <!-- Rent details -->
                        <div class="col-12 col-sm-6 d-flex flex-column gap-3">
                            <div class="d-flex justify-content-between align-items-center py-2.5 text-sm">
                                <span class="text-secondary fw-medium">Monthly Rent</span>
                                <strong class="text-primary font-outfit fs-5">₹{{ number_format($hostel->monthly_rent) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2.5 text-sm">
                                <span class="text-secondary fw-medium">Security Deposit</span>
                                <strong class="text-dark fw-bold">
                                    {{ $hostel->security_deposit ? '₹' . number_format($hostel->security_deposit) : 'Nil' }}
                                </strong>
                            </div>
                        </div>
                        
                        <!-- Room Details -->
                        <div class="col-12 col-sm-6 d-flex flex-column gap-3">
                            <div class="d-flex justify-content-between align-items-center py-2.5 text-sm">
                                <span class="text-secondary fw-medium">Room Configurations</span>
                                <span class="text-dark fw-bold capitalize">
                                    {{ is_array($hostel->room_types) ? implode(', ', $hostel->room_types) : 'Single' }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2.5 text-sm">
                                <span class="text-secondary fw-medium">Total / Available Rooms</span>
                                <span class="text-dark fw-bold">
                                    {{ $hostel->total_rooms ?? 'N/A' }} / {{ $hostel->available_rooms ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Facilities -->
                <div class="card border-0 shadow-soft p-4 rounded-3xl bg-white mb-4">
                    <h5 class="font-outfit fw-bold text-dark mb-4">Facilities & Amenities</h5>
                    @if($hostel->facilities->count() > 0)
                        <div class="row g-3">
                            @foreach($hostel->facilities as $facility)
                                <div class="col-6 col-sm-4 col-md-3">
                                    <div class="d-flex align-items-center gap-2 p-3 bg-light rounded-xl border border-light-subtle text-xs flex-column">
                                        <span class="fs-6 text-primary">{{ $facility->icon ?? '⚡' }}</span>
                                        <span class="text-dark fw-bold">{{ $facility->title }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted small italic mb-0">No specific facilities listed.</p>
                    @endif
                </div>

                <!-- Distance to Coaching Centers -->
                <div class="card border-0 shadow-soft p-4 rounded-3xl bg-white mb-4">
                    <h5 class="font-outfit fw-bold text-dark mb-4">Proximity to Coaching Centers</h5>
                    @if($hostel->coachingCenters->count() > 0)
                        <div class="table-responsive">
                            <table class="table align-middle text-sm text-secondary mb-0">
                                <thead class="table-light text-uppercase text-dark font-semibold">
                                    <tr>
                                        <th class="px-4 py-3  ">Coaching Center</th>
                                        <th class="px-4 py-3  ">Distance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($hostel->coachingCenters as $center)
                                        <tr>
                                            <td class="px-4 py-3 fw-bold text-dark d-flex align-items-center gap-2 border-0">
                                                <i class="fa-solid fa-graduation-cap text-warning fs-5"></i>
                                                <span>{{ $center->title }}</span>
                                            </td>
                                            <td class="px-4 py-3 border-0">
                                                <span class="badge bg-primary bg-opacity-10 text-primary font-bold px-2.5 py-1.5 rounded text-xs">
                                                    {{ number_format($center->pivot->distance_km, 2) }} km away
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted small italic mb-0">No coaching centers proximity details listed.</p>
                    @endif
                </div>

                <!-- Leaflet Interactive Map -->
                @if($hostel->latitude && $hostel->longitude)
                    <div class="card border-0 shadow-soft p-4 rounded-3xl bg-white mb-4">
                        <h5 class="font-outfit fw-bold text-dark mb-3">Map Location</h5>
                        <div id="hostelMap" class="w-100 rounded-3xl border" style="height: 320px;"></div>
                        @if($hostel->google_map_url)
                            <a href="{{ $hostel->google_map_url }}" target="_blank" class="btn btn-link p-0 text-decoration-none small fw-semibold text-primary mt-2">
                                Open in Google Maps <i class="fa-solid fa-arrow-right-long fs-6"></i>
                            </a>
                        @endif
                    </div>
                @endif

                <!-- Reviews display -->
                <div class="card border-0 shadow-soft p-4 rounded-3xl bg-white mb-4">
                    <h5 class="font-outfit fw-bold text-dark mb-4">Student Reviews</h5>
                    
                    @php
                        $approvedReviews = $hostel->reviews->where('status', 'approved');
                    @endphp

                    @if($approvedReviews->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($approvedReviews as $review)
                                <div class="list-group-item py-4 px-0 border-light-subtle">
                                    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white font-bold rounded-circle uppercase text-xs" style="width: 32px; height: 32px;">
                                                {{ substr($review->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h6 class="font-outfit fw-bold text-dark small mb-0">{{ $review->user->name }}</h6>
                                                <span class="text-muted text-[10px] d-block">{{ $review->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>

                                        <div class="text-warning small">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-light-emphasis opacity-25' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-secondary small italic leading-relaxed ps-md-5 mb-0">
                                        "{{ $review->review }}"
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 bg-light bg-opacity-50 rounded-3xl border border-dashed">
                            <p class="text-muted small mb-0">No reviews written for this hostel yet.</p>
                        </div>
                    @endif
                </div>

                <!-- Review Form -->
                <livewire:review-form :hostelId="$hostel->id" />
            </div>

            <!-- Right Column: Sidebar (Booking / Inquiry Card) -->
            <div class="col-12 col-lg-4" style="position: sticky; top: 100px;">
                <livewire:inquiry-form :hostelId="$hostel->id" />

                <div class="card border-0 shadow-soft p-4 rounded-3xl bg-white mt-4">
                    <h5 class="font-outfit fw-bold text-dark mb-2">Ready to Book?</h5>
                    <p class="text-secondary small mb-3">Submit your details directly to the owner to request admission into this hostel property.</p>
                    <livewire:hostel-application-form :hostelId="$hostel->id" />
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet JS Map Initialization -->
    @if($hostel->latitude && $hostel->longitude)
        @push('scripts')
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const map = L.map('hostelMap').setView([{{ $hostel->latitude }}, {{ $hostel->longitude }}], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
                    }).addTo(map);

                    L.marker([{{ $hostel->latitude }}, {{ $hostel->longitude }}]).addTo(map)
                        .bindPopup('<strong>{{ $hostel->title }}</strong><br>{{ $hostel->address }}')
                        .openPopup();
                });
            </script>
        @endpush
    @endif

    <style>
        .hover-scale-img:hover {
            transform: scale(1.03);
        }
        .rounded-xl {
            border-radius: 0.75rem !important;
        }
    </style>
</x-app-layout>
