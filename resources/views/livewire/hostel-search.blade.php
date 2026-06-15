<div class="row g-4">
    <!-- FILTER SIDEBAR (col-lg-3) -->
    <aside class="col-12 col-lg-3">
        <div class="card border-0 shadow-soft p-4 rounded-3xl bg-white" style="position: sticky; top: 100px;">
            <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                <h6 class="font-outfit fw-bold text-dark mb-0">Filters</h6>
                <button wire:click="resetFilters" class="btn btn-link p-0 text-decoration-none small fw-semibold text-primary">Reset All</button>
            </div>

            <!-- Search input -->
            <div class="mb-3">
                <label class="form-label text-uppercase text-muted fw-bold small tracking-wider mb-2" style="font-size: 10px; letter-spacing: 0.5px;">Search Keywords</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-light-subtle" style="border-top-left-radius: 0.75rem; border-bottom-left-radius: 0.75rem;"><i class="fa-solid fa-magnifying-glass text-muted small"></i></span>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Type hostel name..." class="form-control border-light-subtle text-sm" style="border-top-right-radius: 0.75rem; border-bottom-right-radius: 0.75rem; padding-top: 8px; padding-bottom: 8px;">
                </div>
            </div>

            <!-- Area Filter -->
            <div class="mb-3">
                <label class="form-label text-uppercase text-muted fw-bold small tracking-wider mb-2" style="font-size: 10px; letter-spacing: 0.5px;">Select Area</label>
                <select wire:model.live="area" class="form-select border-light-subtle rounded-xl text-sm" style="padding: 8px 12px; background-size: 10px 10px;">
                    <option value="">All Areas</option>
                    @foreach($areas as $a)
                        <option value="{{ $a->slug }}">{{ $a->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Coaching Center Filter -->
            <div class="mb-3">
                <label class="form-label text-uppercase text-muted fw-bold small tracking-wider mb-2" style="font-size: 10px; letter-spacing: 0.5px;">Near Coaching</label>
                <select wire:model.live="coaching" class="form-select border-light-subtle rounded-xl text-sm" style="padding: 8px 12px; background-size: 10px 10px;">
                    <option value="">All Centers</option>
                    @foreach($coachingCenters as $c)
                        <option value="{{ $c->id }}">{{ $c->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Gender Filter -->
            <div class="mb-3">
                <label class="form-label text-uppercase text-muted fw-bold small tracking-wider mb-2 d-block" style="font-size: 10px; letter-spacing: 0.5px;">Accommodation For</label>
                <div class="d-flex gap-2" role="group">
                    @foreach(['boys' => 'Boys', 'girls' => 'Girls', 'coed' => 'Co-ed'] as $val => $label)
                        <button type="button" wire:click="$set('gender', '{{ $gender === $val ? '' : $val }}')" class="btn flex-fill border py-2 small fw-bold text-xs transition-all" style="border-radius: 0.75rem; font-size: 11px;
                            {{ $gender === $val ? 'background-color: var(--bs-primary); border-color: var(--bs-primary); color: #fff; box-shadow: 0 4px 10px rgba(61, 95, 234, 0.2);' : 'background-color: #f8f9fa; border-color: #dee2e6; color: #495057;' }}
                        ">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Room Sharing Type -->
            <div class="mb-3">
                <label class="form-label text-uppercase text-muted fw-bold small tracking-wider mb-2" style="font-size: 10px; letter-spacing: 0.5px;">Room Sharing</label>
                <select wire:model.live="room_type" class="form-select border-light-subtle rounded-xl text-sm" style="padding: 8px 12px; background-size: 10px 10px;">
                    <option value="">Any Room Type</option>
                    <option value="single">Single Room</option>
                    <option value="double">Double Sharing</option>
                    <option value="triple">Triple Sharing</option>
                </select>
            </div>

            <!-- Budget Range Filter -->
            <div class="mb-3">
                <label class="form-label text-uppercase text-muted fw-bold small tracking-wider mb-2 d-block" style="font-size: 10px; letter-spacing: 0.5px;">Monthly Budget (₹)</label>
                <div class="d-flex align-items-center gap-2">
                    <input type="number" wire:model.live.debounce.500ms="min_price" placeholder="Min" class="form-control border-light-subtle rounded-xl text-sm" style="padding: 8px 12px;">
                    <span class="text-secondary small fw-medium">to</span>
                    <input type="number" wire:model.live.debounce.500ms="max_price" placeholder="Max" class="form-control border-light-subtle rounded-xl text-sm" style="padding: 8px 12px;">
                </div>
            </div>

            <!-- Amenities/Facilities Checklist -->
            <div>
                <label class="form-label text-uppercase text-muted fw-bold small tracking-wider mb-2 d-block" style="font-size: 10px; letter-spacing: 0.5px;">Amenities</label>
                <div class="overflow-y-auto pe-1" style="max-height: 180px;">
                    @foreach($facilities as $f)
                        <div class="form-check mb-2 cursor-pointer">
                            <input class="form-check-input border-light-subtle" type="checkbox" wire:model.live="selected_facilities" value="{{ $f->id }}" id="facilityCheck-{{ $f->id }}" style="width: 16px; height: 16px; margin-top: 3px; border-radius: 0.25rem;">
                            <label class="form-check-label text-secondary small select-none cursor-pointer ms-2" for="facilityCheck-{{ $f->id }}" style="font-size: 12.5px;">
                                {{ $f->title }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </aside>

    <!-- HOSTELS LISTING GRID (col-lg-9) -->
    <div class="col-12 col-lg-9 space-y-4">
        <!-- Top Toolbar -->
        <div class="card border-0 shadow-soft p-3 rounded-2xl bg-white mb-4">
            <div class="row align-items-center justify-content-between g-2">
                <div class="col-auto">
                    <span class="text-secondary small fw-medium">
                        Found <strong class="text-dark">{{ $hostels->total() }}</strong> hostels matching filters
                    </span>
                </div>
                <div class="col-auto d-flex align-items-center gap-2">
                    <label class="text-muted small fw-medium whitespace-nowrap mb-0">Sort By:</label>
                    <select wire:model.live="sort" class="form-select form-select-sm border-light-subtle text-xs" style="width: auto;">
                        <option value="latest">Latest Listed</option>
                        <option value="rent_asc">Price: Low to High</option>
                        <option value="rent_desc">Price: High to Low</option>
                        <option value="views_desc">Most Viewed</option>
                        <option value="rating_desc">Highest Rated</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- SKELETON LOADER -->
        <div wire:loading.delay class="w-100">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @for($i = 0; $i < 6; $i++)
                    <div class="col">
                        <div class="card border-0 shadow-soft rounded-3xl overflow-hidden animate-pulse bg-white">
                            <div class="bg-body-secondary" style="height: 180px;"></div>
                            <div class="card-body p-4 space-y-3">
                                <div class="bg-body-secondary rounded-1 w-25" style="height: 12px;"></div>
                                <div class="bg-body-secondary rounded-1 w-75" style="height: 18px;"></div>
                                <div class="bg-body-secondary rounded-1 w-50" style="height: 12px;"></div>
                                <div class="bg-body-secondary rounded-3 w-100 mt-3" style="height: 38px;"></div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <!-- HOSTELS GRID -->
        <div wire:loading.remove>
            @if($hostels->count() > 0)
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach($hostels as $hostel)
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

                <!-- Pagination -->
                <div class="mt-5 pt-3 d-flex justify-content-center">
                    {{ $hostels->links('livewire.custom-pagination') }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5 px-3 bg-white border border-light-subtle rounded-4 shadow-sm">
                    <div class="text-muted opacity-25 mb-3">
                        <i class="fa-solid fa-map-location-dot display-3"></i>
                    </div>
                    <h5 class="font-outfit fw-bold text-dark mb-1">No accommodations found</h5>
                    <p class="text-muted small max-w-sm mx-auto mb-4">No hostels matched your exact filters. Try tweaking your filters or search keywords.</p>
                    <button wire:click="resetFilters" class="btn btn-primary px-4 py-2 rounded-xl fw-bold shadow-sm">
                        Clear All Filters
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease !important;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(15, 23, 42, 0.08) !important;
    }
    .hover-scale {
        transition: transform 0.4s ease !important;
    }
    .hover-card:hover .hover-scale {
        transform: scale(1.04);
    }
    .rounded-4 {
        border-radius: 1rem !important;
    }
    .rounded-xl {
        border-radius: 0.75rem !important;
    }
    .hover-color-primary:hover {
        color: var(--bs-primary) !important;
    }
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
 
</style>
