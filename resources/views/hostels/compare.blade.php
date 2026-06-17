<x-app-layout>
    <div class="container py-5">
        <div class="mb-5 text-center text-md-start">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-primary fw-medium">Home</a></li>
                    <li class="breadcrumb-item"><a href="/hostels" class="text-decoration-none text-primary fw-medium">Hostels</a></li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">Compare Hostels</li>
                </ol>
            </nav>
            <h2 class="font-outfit fw-bold text-dark mb-1">Compare Accommodations</h2>
            <p class="text-secondary small">Analyze rent, convenience scores, real costs, and features side-by-side to make the best choice.</p>
        </div>

        @if($hostels && count($hostels) >= 1)
            <div class="table-responsive bg-white rounded-4 border border-light-subtle shadow-soft overflow-hidden mb-4">
                <table class="table align-middle mb-0 text-sm text-secondary table-bordered border-light-subtle">
                    <thead class="table-light text-dark font-semibold">
                        <tr>
                            <th class="px-4 py-3" style="width: 25%; min-width: 180px;">Hostel Parameters</th>
                            @foreach($hostels as $hostel)
                                <th class="px-4 py-3 text-center" style="width: 25%; min-width: 200px;">
                                    <div class="d-flex flex-column align-items-center">
                                        <!-- Image -->
                                        <div class="rounded-xl overflow-hidden mb-2.5 bg-light" style="width: 100px; height: 75px;">
                                            @if($hostel->primary_image)
                                                <img src="{{ $hostel->primary_image }}" alt="" class="w-100 h-100 object-fit-cover">
                                            @else
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-primary" style="background: rgba(61, 95, 234, 0.05);">
                                                    <i class="fa-solid fa-building fs-4"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Title -->
                                        <h6 class="font-outfit fw-bold text-dark mb-1 line-clamp-1" style="font-size: 13.5px;">{{ $hostel->title }}</h6>
                                        <small class="text-muted mb-2"><i class="fa-solid fa-location-dot me-0.5"></i> {{ $hostel->area->title }}</small>
                                        
                                        <div class="d-flex gap-1.5 flex-wrap justify-content-center">
                                            <a href="/hostels/{{ $hostel->area->slug }}/{{ $hostel->slug }}" class="btn btn-primary btn-xs px-2.5 py-1 rounded fw-semibold text-xs" style="font-size: 10px;">View Info</a>
                                            <button class="btn btn-outline-danger btn-xs px-2.5 py-1 rounded fw-semibold text-xs remove-from-compare" data-id="{{ $hostel->id }}" style="font-size: 10px;">Remove</button>
                                        </div>
                                    </div>
                                </th>
                            @endforeach
                            @if(count($hostels) < 3)
                                @for($i = count($hostels); $i < 3; $i++)
                                    <th class="px-4 py-3 text-center bg-light bg-opacity-25" style="width: 25%; min-width: 200px;">
                                        <div class="d-flex flex-column align-items-center justify-content-center py-4 text-muted border border-dashed rounded-3xl" style="height: 150px;">
                                            <i class="fa-solid fa-plus fs-3 mb-2 opacity-50"></i>
                                            <span class="small fw-semibold">Add another</span>
                                            <a href="/hostels" class="btn btn-link btn-xs p-0 text-decoration-none small mt-1">Browse Hostels</a>
                                        </div>
                                    </th>
                                @endfor
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Monthly Rent -->
                        <tr>
                            <td class="px-4 py-3 fw-bold text-dark"><i class="fa-solid fa-indian-rupee-sign text-primary me-2"></i>Monthly Base Rent</td>
                            @foreach($hostels as $hostel)
                                <td class="px-4 py-3 text-center text-dark fw-bold fs-6">₹{{ number_format($hostel->monthly_rent) }}<span class="text-muted small fw-normal" style="font-size: 11px;">/mo</span></td>
                            @endforeach
                            @if(count($hostels) < 3) <td colspan="{{ 3 - count($hostels) }}" class="bg-light bg-opacity-10"></td> @endif
                        </tr>

                        <!-- Real Monthly Cost -->
                        <tr class="bg-light bg-opacity-10">
                            <td class="px-4 py-3 fw-bold text-dark">
                                <i class="fa-solid fa-wallet text-success me-2"></i>Real Monthly Cost
                                <span class="d-block text-muted small fw-normal mt-0.5" style="font-size: 10.5px;">Includes electricity, mess, laundry, etc.</span>
                            </td>
                            @foreach($hostels as $hostel)
                                <td class="px-4 py-3 text-center text-primary fw-extrabold fs-5">
                                    ₹{{ number_format($hostel->real_monthly_cost) }}<span class="text-muted small fw-normal" style="font-size: 11px;">/mo</span>
                                    
                                    <!-- Cost breakdown tooltip/popover -->
                                    <div class="text-muted fw-semibold small mt-1.5" style="font-size: 10px;">
                                        (Rent: ₹{{ number_format($hostel->monthly_rent) }} + Charges: ₹{{ number_format($hostel->real_monthly_cost - $hostel->monthly_rent) }})
                                    </div>
                                </td>
                            @endforeach
                            @if(count($hostels) < 3) <td colspan="{{ 3 - count($hostels) }}" class="bg-light bg-opacity-10"></td> @endif
                        </tr>

                        <!-- Area Rent Comparison -->
                        <tr>
                            <td class="px-4 py-3 fw-bold text-dark"><i class="fa-solid fa-circle-nodes text-muted me-2"></i>Area Comparison</td>
                            @foreach($hostels as $hostel)
                                @php $comp = $hostel->area_rent_comparison; @endphp
                                <td class="px-4 py-3 text-center">
                                    @if($comp['is_saving'])
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1.5 rounded-pill fw-bold text-xs">
                                            Saves ₹{{ number_format($comp['difference']) }}/mo
                                        </span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 px-2.5 py-1.5 rounded-pill fw-bold text-xs">
                                            +₹{{ number_format($comp['difference']) }}/mo extra
                                        </span>
                                    @endif
                                </td>
                            @endforeach
                            @if(count($hostels) < 3) <td colspan="{{ 3 - count($hostels) }}" class="bg-light bg-opacity-10"></td> @endif
                        </tr>

                        <!-- Kota Survival Score -->
                        <tr class="bg-light bg-opacity-10">
                            <td class="px-4 py-3 fw-bold text-dark">
                                <i class="fa-solid fa-route text-warning me-2"></i>Kota Survival Score
                                <span class="d-block text-muted small fw-normal mt-0.5" style="font-size: 10.5px;">Proximity convenience rating (0-100)</span>
                            </td>
                            @foreach($hostels as $hostel)
                                <td class="px-4 py-3 text-center">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-success text-white font-outfit fw-bold rounded-circle shadow-sm mb-1.5" style="width: 44px; height: 44px; font-size: 1.1rem;
                                        background: {{ $hostel->survival_score >= 80 ? 'linear-gradient(135deg, #198754 0%, #20c997 100%)' : ($hostel->survival_score >= 60 ? 'linear-gradient(135deg, #ffc107 0%, #ffca2c 100%)' : 'linear-gradient(135deg, #dc3545 0%, #ea868f 100%)') }} !important;
                                    ">
                                        {{ $hostel->survival_score }}
                                    </div>
                                    
                                    <div class="text-xs text-muted">
                                        @php $sub = $hostel->getSurvivalSubScores(); @endphp
                                        Coaching Access: {{ $sub['coaching'] }}%<br>
                                        Study Resources: {{ $sub['study'] }}%
                                    </div>
                                </td>
                            @endforeach
                            @if(count($hostels) < 3) <td colspan="{{ 3 - count($hostels) }}" class="bg-light bg-opacity-10"></td> @endif
                        </tr>

                        <!-- Trust Score -->
                        <tr>
                            <td class="px-4 py-3 fw-bold text-dark">
                                <i class="fa-solid fa-ranking-star text-primary me-2"></i>Trust Score & Rank
                                <span class="d-block text-muted small fw-normal mt-0.5" style="font-size: 10.5px;">Calculated trust algorithm (0-100)</span>
                            </td>
                            @foreach($hostels as $hostel)
                                <td class="px-4 py-3 text-center">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white font-outfit fw-bold rounded-circle shadow-sm mb-1.5" style="width: 44px; height: 44px; font-size: 1.1rem;">
                                        {{ $hostel->hostel_score }}
                                    </div>
                                    @php
                                        $kRank = \App\Models\Hostel::active()->where('hostel_score', '>', $hostel->hostel_score)->count() + 1;
                                    @endphp
                                    <div class="text-xs fw-bold text-dark">#{{ $kRank }} in Kota</div>
                                </td>
                            @endforeach
                            @if(count($hostels) < 3) <td colspan="{{ 3 - count($hostels) }}" class="bg-light bg-opacity-10"></td> @endif
                        </tr>

                        <!-- Distance to Coaching -->
                        <tr class="bg-light bg-opacity-10">
                            <td class="px-4 py-3 fw-bold text-dark"><i class="fa-solid fa-graduation-cap text-muted me-2"></i>Distance to Coaching</td>
                            @foreach($hostels as $hostel)
                                <td class="px-4 py-3 text-center text-dark fw-medium">
                                    {{ $hostel->distance_coaching ? $hostel->distance_coaching . ' km' : 'N/A' }}
                                </td>
                            @endforeach
                            @if(count($hostels) < 3) <td colspan="{{ 3 - count($hostels) }}" class="bg-light bg-opacity-10"></td> @endif
                        </tr>

                        <!-- Room Types -->
                        <tr>
                            <td class="px-4 py-3 fw-bold text-dark"><i class="fa-solid fa-door-open text-muted me-2"></i>Room Types Available</td>
                            @foreach($hostels as $hostel)
                                <td class="px-4 py-3 text-center text-dark text-capitalize">
                                    {{ is_array($hostel->room_types) ? implode(', ', $hostel->room_types) : 'Single' }}
                                </td>
                            @endforeach
                            @if(count($hostels) < 3) <td colspan="{{ 3 - count($hostels) }}" class="bg-light bg-opacity-10"></td> @endif
                        </tr>

                        <!-- Verified Status -->
                        <tr class="bg-light bg-opacity-10">
                            <td class="px-4 py-3 fw-bold text-dark"><i class="fa-solid fa-shield-halved text-muted me-2"></i>Verification</td>
                            @foreach($hostels as $hostel)
                                <td class="px-4 py-3 text-center">
                                    @if($hostel->verified)
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2.5 py-1.5 rounded-pill fw-bold text-xs">
                                            <i class="fa-solid fa-circle-check me-0.5"></i> Verified
                                        </span>
                                    @else
                                        <span class="badge bg-light text-muted border px-2.5 py-1.5 rounded-pill fw-bold text-xs">
                                            Unverified
                                        </span>
                                    @endif
                                </td>
                            @endforeach
                            @if(count($hostels) < 3) <td colspan="{{ 3 - count($hostels) }}" class="bg-light bg-opacity-10"></td> @endif
                        </tr>

                        <!-- Ratings & Reviews -->
                        <tr>
                            <td class="px-4 py-3 fw-bold text-dark"><i class="fa-solid fa-star text-warning me-2"></i>Student Feedback</td>
                            @foreach($hostels as $hostel)
                                <td class="px-4 py-3 text-center">
                                    @if($hostel->reviews_avg_rating)
                                        <span class="text-warning fw-extrabold fs-6">★ {{ number_format($hostel->reviews_avg_rating, 1) }}</span>
                                        <span class="text-muted d-block small" style="font-size: 11px;">({{ $hostel->approvedReviews()->count() }} approved reviews)</span>
                                    @else
                                        <span class="text-muted small italic">No ratings yet</span>
                                    @endif
                                </td>
                            @endforeach
                            @if(count($hostels) < 3) <td colspan="{{ 3 - count($hostels) }}" class="bg-light bg-opacity-10"></td> @endif
                        </tr>

                        <!-- Facilities -->
                        <tr class="bg-light bg-opacity-10">
                            <td class="px-4 py-3 fw-bold text-dark"><i class="fa-solid fa-list-check text-muted me-2"></i>Amenities & Facilities</td>
                            @foreach($hostels as $hostel)
                                <td class="px-4 py-3">
                                    <div class="d-flex flex-wrap gap-1.5 justify-content-center">
                                        @foreach($hostel->facilities as $fac)
                                            <span class="badge bg-light text-dark border px-2 py-1 small rounded" style="font-size: 10px; font-weight: 500;">
                                                {{ $fac->icon ?? '⚡' }} {{ $fac->title }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                            @endforeach
                            @if(count($hostels) < 3) <td colspan="{{ 3 - count($hostels) }}" class="bg-light bg-opacity-10"></td> @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <!-- Empty comparison list -->
            <div class="text-center py-5 px-3 bg-white border border-light-subtle rounded-4 shadow-soft">
                <div class="text-muted opacity-25 mb-4">
                    <i class="fa-solid fa-code-compare display-2"></i>
                </div>
                <h4 class="font-outfit fw-bold text-dark">No hostels selected to compare</h4>
                <p class="text-secondary small max-w-sm mx-auto my-2">Please go back to the explorer page, select up to 3 hostels using the compare buttons, and check them side by side.</p>
                <a href="/hostels" class="btn btn-primary px-4 py-2 mt-4 rounded-xl fw-bold shadow-sm">
                    Browse Hostels
                </a>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Remove from compare button inside table
                document.querySelectorAll('.remove-from-compare').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = parseInt(this.getAttribute('data-id'));
                        let list = [];
                        try {
                            list = JSON.parse(localStorage.getItem('compare_hostels')) || [];
                        } catch(e) {
                            list = [];
                        }
                        
                        list = list.filter(item => item !== id);
                        localStorage.setItem('compare_hostels', JSON.stringify(list));
                        
                        // Reload page with new list of IDs in query params
                        if (list.length > 0) {
                            window.location.href = '/compare?ids=' + list.join(',');
                        } else {
                            window.location.href = '/compare';
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
