<x-layouts.dashboard>
    <div class="d-flex flex-column gap-4">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
            <div>
                <h2 class="font-outfit fs-3 fw-bold text-dark mb-1">Manage Hostels</h2>
                <p class="text-secondary small mb-0">Add, update, and manage your Kota hostel listings.</p>
            </div>
            <div>
                <a href="{{ route('owner.hostels.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 rounded-pill shadow-sm">
                    <i class="fa-solid fa-plus"></i>
                    <span>Add New Hostel</span>
                </a>
            </div>
        </div>

        @if($hostels->count() > 0)
            <div class="d-flex flex-column gap-3">
                @foreach($hostels as $hostel)
                    <div class="card border border-light-subtle rounded-2xl p-4 hover-shadow transition-all bg-white">
                        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-4">
                            <div class="d-flex align-items-start gap-3 flex-grow-1">
                                <!-- Thumbnail -->
                                <div class="rounded-xl overflow-hidden bg-light d-flex align-items-center justify-content-center flex-shrink-0" style="width: 80px; height: 80px;">
                                    @if($hostel->getMedia('gallery')->first())
                                        <img src="{{ $hostel->getMedia('gallery')->first()->getUrl() }}" alt="" class="w-100 h-100 object-cover">
                                    @else
                                        <i class="fa-solid fa-hotel text-muted opacity-25 fs-2"></i>
                                    @endif
                                </div>

                                <!-- Detail details -->
                                <div class="d-flex flex-column gap-1">
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <h5 class="font-outfit fw-bold text-dark mb-0 leading-tight">{{ $hostel->title }}</h5>
                                        <span class="badge text-uppercase font-semibold tracking-wider px-2 py-1 rounded-3
                                            {{ $hostel->status === 'active' ? 'bg-success text-white' : '' }}
                                            {{ $hostel->status === 'draft' ? 'bg-warning text-dark' : '' }}
                                            {{ $hostel->status === 'inactive' ? 'bg-secondary text-white' : '' }}
                                        " style="font-size: 10px;">
                                            {{ $hostel->status }}
                                        </span>
                                        @if($hostel->verified)
                                            <span class="badge bg-primary-light text-primary-color px-2 py-1 rounded-3 font-semibold" style="font-size: 10px;">
                                                <i class="fa-solid fa-circle-check me-1"></i>Verified
                                            </span>
                                        @endif
                                        @if($hostel->featured)
                                            <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1 rounded-3 font-semibold" style="font-size: 10px; color: #664d03 !important;">
                                                <i class="fa-solid fa-star me-1"></i>Featured
                                            </span>
                                        @endif
                                    </div>

                                    <p class="text-secondary small mb-1">
                                        <i class="fa-solid fa-location-dot me-1 text-muted"></i>{{ $hostel->area->title }} &bull; Rent: <strong class="text-primary-color">₹{{ number_format($hostel->monthly_rent) }}/mo</strong>
                                    </p>

                                    <div class="d-flex align-items-center gap-3 text-muted" style="font-size: 11px;">
                                        <span><i class="fa-solid fa-eye me-1"></i> Views: {{ $hostel->views }}</span>
                                        <span><i class="fa-solid fa-envelope me-1"></i> Inquiries: {{ $hostel->inquiries()->count() }}</span>
                                        <span><i class="fa-solid fa-star me-1"></i> Reviews: {{ $hostel->reviews()->count() }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2 w-100 w-md-auto justify-content-md-end justify-content-start">
                                <a href="{{ route('owner.hostels.edit', $hostel) }}" class="btn btn-primary-light btn-sm text-primary-color px-3 rounded-pill text-xs fw-semibold">
                                    Edit details
                                </a>
                                <a href="/hostels/{{ $hostel->area->slug }}/{{ $hostel->slug }}" target="_blank" class="btn btn-outline-secondary btn-sm px-3 rounded-pill text-xs fw-semibold">
                                    View Live
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 border border-dashed rounded-3xl bg-light bg-opacity-25">
                <div class="text-muted opacity-25 mb-4">
                    <i class="fa-solid fa-hotel display-4"></i>
                </div>
                <h4 class="font-outfit fw-bold text-dark">No hostels registered</h4>
                <p class="text-secondary small max-w-sm mx-auto my-2">You haven't listed any hostels yet. Click 'Add New Hostel' to publish your property.</p>
            </div>
        @endif
    </div>

    <style>
        .hover-shadow:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
        }
        .bg-primary-light {
            background-color: rgba(var(--bs-primary-rgb), 0.08) !important;
        }
        .text-primary-color {
            color: var(--bs-primary) !important;
        }
    </style>
</x-layouts.dashboard>
