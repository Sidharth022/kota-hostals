<x-layouts.dashboard>
    <div class="d-flex flex-column gap-4">
        <div>
            <h2 class="font-outfit fs-3 fw-bold text-dark mb-1">My Reviews</h2>
            <p class="text-secondary small">Feedback you have shared about accommodations.</p>
        </div>

        @if($reviews->count() > 0)
            <div class="d-flex flex-column gap-3">
                @foreach($reviews as $review)
                    <div class="card border border-light-subtle rounded-2xl p-4 hover-shadow transition-all bg-white d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                            <h5 class="font-outfit fw-bold text-dark mb-0">
                                <a href="/hostels/{{ $review->hostel->area->slug }}/{{ $review->hostel->slug }}" class="text-decoration-none text-dark hover-color-primary">
                                    {{ $review->hostel->title }}
                                </a>
                            </h5>
                            <span class="badge px-2.5 py-1 rounded-pill text-xs fw-bold
                                {{ $review->status === 'approved' ? 'bg-success text-white' : '' }}
                                {{ $review->status === 'pending' ? 'bg-warning text-dark' : '' }}
                                {{ $review->status === 'rejected' ? 'bg-danger text-white' : '' }}
                            ">
                                {{ ucfirst($review->status) }}
                            </span>
                        </div>

                        <!-- Star Rating -->
                        <div class="d-flex align-items-center gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star" style="{{ $i <= $review->rating ? 'color: #ffc107;' : 'color: #dee2e6;' }}"></i>
                            @endfor
                        </div>

                        <p class="text-secondary small mb-1 italic">"{{ $review->review }}"</p>
                        
                        <div class="text-muted text-xs border-top border-light-subtle pt-2.5 d-flex align-items-center justify-content-between" style="font-size: 11px;">
                            <span>Reviewed on: {{ $review->created_at->format('d M Y') }}</span>
                            <a href="/hostels/{{ $review->hostel->area->slug }}/{{ $review->hostel->slug }}" class="text-primary text-decoration-none fw-semibold">
                                View Hostel
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 border border-dashed rounded-3xl bg-light bg-opacity-25">
                <div class="text-muted opacity-25 mb-4">
                    <i class="fa-regular fa-star-half-stroke display-4"></i>
                </div>
                <h4 class="font-outfit fw-bold text-dark">No reviews yet</h4>
                <p class="text-secondary small max-w-sm mx-auto my-2">You haven't written any reviews yet. Share your experience about stays in Kota to help other students.</p>
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
