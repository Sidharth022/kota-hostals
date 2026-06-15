<x-app-layout>
    <!-- 1. HERO SECTION -->
    <div class="position-relative overflow-hidden bg-primary-light py-5 py-md-5 mb-5">
        <div class="container py-5 text-center">
            <div class="mb-4">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill uppercase tracking-wider small fw-bold">📍 Student Hub of India</span>
            </div>
            
            <h1 class="font-outfit display-4 fw-extrabold text-dark tracking-tight leading-tight max-w-4xl mx-auto mb-3">
                Find the Perfect Hostel in <span class="text-primary position-relative d-inline-block">Kota</span> for Your Coaching Journey
            </h1>
            
            <p class="text-muted lead max-w-2xl mx-auto mb-5">
                Shortlist premium student hostels and PGs near Allen, Resonance, Motion, and other coaching institutes in Kota. Save time and focus on your studies!
            </p>

            <!-- Search Widget Bar -->
            <div class="card border-0 shadow-soft-lg p-3 max-w-3xl mx-auto rounded-3xl bg-white mb-3" style="max-width: 720px;">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-md d-flex align-items-center gap-2 px-3">
                        <i class="fa-solid fa-magnifying-glass text-secondary"></i>
                        <input type="text" id="homeSearchInput" placeholder="Enter landmark, coaching institute, or area..." class="form-control border-0 py-2 text-sm focus-ring" style="--bs-focus-ring-color: transparent;">
                    </div>
                    <div class="col-12 col-md-auto">
                        <button onclick="window.location.href='/hostels?search=' + document.getElementById('homeSearchInput').value" class="btn btn-primary w-100 py-2.5 px-4 shadow-sm shadow-primary/10">
                            Search Hostels
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. POPULAR AREAS -->
    <div class="container py-5 mb-5">
        <div class="text-center mb-5">
            <h2 class="font-outfit fw-bold text-dark mb-1">Browse Hostels by Area</h2>
            <p class="text-secondary small">Explore rooms near Kota's major hubs and coaching zones.</p>
        </div>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-4">
            @foreach($popularAreas as $area)
                <div class="col">
                    <a href="/hostels?area={{ $area->slug }}" class="card h-100 border border-light-subtle rounded-3xl text-center p-4 hover-shadow text-decoration-none transition-all bg-white group">
                        <div class="w-12 h-12 rounded-xl bg-primary-light text-primary d-flex align-items-center justify-content-center mx-auto mb-3 shadow-sm hover-primary-bg transition-all rounded" style="width: 48px; height: 48px;">
                            <i class="fa-solid fa-location-dot fs-5"></i>
                        </div>
                        <h6 class="font-outfit fw-bold text-dark mb-1 group-hover-color">{{ $area->title }}</h6>
                        <span class="text-muted small">{{ $area->hostels_count }} Listings</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 3. FEATURED LISTINGS -->
    <div class="bg-light py-5 mb-5 border-top border-bottom">
        <div class="container py-4">
            <div class="d-flex items-center justify-content-between gap-4 flex-wrap mb-5">
                <div>
                    <h2 class="font-outfit fw-bold text-dark mb-1">Featured Accommodations</h2>
                    <p class="text-secondary small mb-0">Directly verified, high-rating hostels with excellent amenities.</p>
                </div>
                <a href="/hostels?featured=1" class="text-primary fw-semibold text-decoration-none hover:text-primary-emphasis d-flex align-items-center gap-1">
                    View All Featured <i class="fa-solid fa-arrow-right-long small"></i>
                </a>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($featuredHostels as $hostel)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white hover-card transition-all">
                            <!-- Image Container -->
                            <div class="position-relative overflow-hidden bg-light" style="height: 190px;">
                                <!-- Gender Badge -->
                                <span class="position-absolute top-0 start-0 m-3 z-3 badge px-3 py-2 text-uppercase small fw-bold shadow-sm
                                    {{ $hostel->gender_type === 'boys' ? 'bg-primary text-white' : '' }}
                                    {{ $hostel->gender_type === 'girls' ? 'bg-danger text-white' : '' }}
                                    {{ $hostel->gender_type === 'coed' ? 'bg-success text-white' : '' }}
                                " style="border-radius: 0.5rem; font-size: 10px; letter-spacing: 0.5px;">
                                    {{ $hostel->gender_type === 'coed' ? 'Co-ed' : ucfirst($hostel->gender_type) }}
                                </span>

                                @if($hostel->getMedia('gallery')->first())
                                    <img src="{{ $hostel->getMedia('gallery')->first()->getUrl() }}" alt="{{ $hostel->title }}" class="w-100 h-100 object-fit-cover hover-scale transition-transform duration-500">
                                @else
                                    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-primary" style="background: linear-gradient(135deg, rgba(61, 95, 234, 0.04) 0%, rgba(61, 95, 234, 0.12) 100%);">
                                        <i class="fa-solid fa-building fs-1 text-primary text-opacity-25 mb-2"></i>
                                        <span class="text-primary fw-bold text-uppercase tracking-wider text-opacity-50" style="font-size: 9px; letter-spacing: 1px;">KotaHostel Premium</span>
                                    </div>
                                @endif

                                @if($hostel->verified)
                                    <span class="position-absolute top-0 end-0 m-3 z-3 bg-white text-primary rounded shadow-sm px-3 py-1 border border-primary-light d-inline-flex align-items-center gap-1 fw-bold" style="font-size: 10px; border-radius: 0.5rem;">
                                        <i class="fa-solid fa-circle-check fs-6 text-primary"></i> Verified
                                    </span>
                                @endif
                            </div>

                            <!-- Details -->
                            <div class="card-body p-4 d-flex flex-column justify-content-between">
                                <div class="mb-3">
                                    <div class="d-flex align-items-center justify-content-between text-muted small mb-2" style="font-size: 11px;">
                                        <span class="fw-medium text-secondary"><i class="fa-solid fa-location-dot me-1"></i>{{ $hostel->area->title }}</span>
                                        @if($hostel->reviews_avg_rating)
                                            <span class="text-warning fw-bold d-flex align-items-center gap-0.5">
                                                ★ {{ number_format($hostel->reviews_avg_rating, 1) }}
                                            </span>
                                        @endif
                                    </div>
                                    <h6 class="font-outfit fw-extrabold text-dark mb-0 line-clamp-1 fs-6">
                                        <a href="/hostels/{{ $hostel->area->slug }}/{{ $hostel->slug }}" class="text-dark text-decoration-none hover-color-primary">
                                            {{ $hostel->title }}
                                        </a>
                                    </h6>
                                </div>

                                <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle">
                                    <div>
                                        <span class="text-muted text-uppercase tracking-wider small d-block" style="font-size: 8px; font-weight: 700;">Starts From</span>
                                        <span class="text-primary fw-extrabold font-outfit fs-5">₹{{ number_format($hostel->monthly_rent) }}<span class="text-muted small fw-normal" style="font-size: 11px;">/mo</span></span>
                                    </div>
                                    <a href="/hostels/{{ $hostel->area->slug }}/{{ $hostel->slug }}" class="btn btn-outline-primary btn-sm px-3 rounded-xl fw-bold text-xs" style="padding-top: 6px; padding-bottom: 6px;">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 4. WHY US -->
    <div class="container py-5 mb-5">
        <div class="text-center mb-5">
            <h2 class="font-outfit fw-bold text-dark mb-1">Why KotaHostel?</h2>
            <p class="text-secondary small">Made specifically for student comfort and peace of mind.</p>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-soft p-4 rounded-3xl bg-white h-100">
                    <div class="mb-3 d-inline-flex p-3 bg-primary-light text-primary rounded-xl" style="width: fit-content;">
                        <i class="fa-solid fa-route fs-4"></i>
                    </div>
                    <h5 class="font-outfit fw-bold text-dark mb-2">Distance to Coaching</h5>
                    <p class="text-secondary small leading-relaxed mb-0">
                        View precise, calculated walking distances to Allen, Resonance, and other popular institutes directly from your room.
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-soft p-4 rounded-3xl bg-white h-100">
                    <div class="mb-3 d-inline-flex p-3 bg-success bg-opacity-10 text-success rounded-xl" style="width: fit-content;">
                        <i class="fa-solid fa-shield-halved fs-4"></i>
                    </div>
                    <h5 class="font-outfit fw-bold text-dark mb-2">Verified Listings</h5>
                    <p class="text-secondary small leading-relaxed mb-0">
                        We list hostels after physical check verifications, ensuring correct pricing, good food hygiene, and secure environments.
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-soft p-4 rounded-3xl bg-white h-100">
                    <div class="mb-3 d-inline-flex p-3 bg-warning bg-opacity-10 text-warning rounded-xl" style="width: fit-content;">
                        <i class="fa-solid fa-comments fs-4"></i>
                    </div>
                    <h5 class="font-outfit fw-bold text-dark mb-2">Direct Owner Contact</h5>
                    <p class="text-secondary small leading-relaxed mb-0">
                        Submit free inquiries to get direct calls or messaging links to owners, bypassing agents and middle-men commissions.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. TESTIMONIALS -->
    @if($testimonials->count() > 0)
        <div class="bg-light py-5 border-top border-bottom mb-5">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <h2 class="font-outfit fw-bold text-dark mb-1">Testimonials from Kota Students</h2>
                    <p class="text-secondary small">Real reviews left by students currently studying and lodging in Kota.</p>
                </div>

                <div class="row g-4">
                    @foreach($testimonials as $t)
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="card border-0 shadow-soft p-4 rounded-3xl bg-white h-100 d-flex flex-column justify-content-between">
                                <div class="mb-3">
                                    <div class="text-warning small mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa-solid fa-star {{ $i <= $t->rating ? 'text-warning' : 'text-light-emphasis opacity-25' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="text-secondary italic small mb-0">"{{ \Illuminate\Support\Str::limit($t->review, 140) }}"</p>
                                </div>

                                <div class="d-flex align-items-center gap-3.5 pt-3 border-top border-light-subtle">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white font-bold rounded-circle uppercase text-xs" style="width: 32px; height: 32px;">
                                        {{ substr($t->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="font-outfit fw-bold text-dark small mb-0 leading-tight">{{ $t->user->name }}</h6>
                                        <span class="text-muted text-[10px] d-block truncate max-w-[120px]">Stayed at {{ $t->hostel->title }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- 6. OWNER REGISTER BANNER -->
    <div class="bg-dark text-white text-center py-5 relative overflow-hidden">
        <div class="container py-4 relative z-10 space-y-4">
            <h2 class="font-outfit display-6 fw-extrabold mb-3 text-white">Are you a Hostel Owner in Kota?</h2>
            <p class="text-secondary leading-relaxed max-w-lg mx-auto mb-4">
                List your hostel or PG on KotaHostel and connect directly with thousands of student aspirants arriving in Kota.
            </p>
            <a href="{{ route('register') }}" class="btn btn-light py-2.5 px-4 font-bold text-primary shadow-lg mt-2">
                Register as Property Owner
            </a>
        </div>
    </div>

    <!-- Hover effects stylesheet overrides -->
    <style>
        .hover-shadow:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04) !important;
            border-color: var(--bs-primary) !important;
        }
        .hover-shadow:hover .group-hover-color {
            color: var(--bs-primary) !important;
        }
        .hover-shadow:hover .hover-primary-bg {
            background-color: var(--bs-primary) !important;
            color: #ffffff !important;
        }
        .hover-color-primary:hover {
            color: var(--bs-primary) !important;
        }
        .object-fit-cover {
            object-fit: cover;
        }
        .hover-scale:hover {
            transform: scale(1.05);
        }
    </style>
</x-app-layout>
