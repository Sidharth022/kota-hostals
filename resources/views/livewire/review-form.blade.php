<div class="card border-0 shadow-soft p-4 rounded-3xl bg-white mt-4">
    <h5 class="font-outfit fw-bold text-dark mb-4">Leave a Review</h5>

    @auth
        <form wire:submit.prevent="submit" class="row g-3">
            <!-- Star Rating Picker -->
            <div class="col-12">
                <label class="form-label text-uppercase text-muted fw-bold small tracking-wider mb-2 d-block">Your Rating</label>
                <div class="d-flex align-items-center gap-2">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" wire:click="setRating({{ $i }})" class="btn p-0 border-0 focus:outline-none">
                            <i class="fa-solid fa-star fs-3 {{ $i <= $rating ? 'text-warning' : 'text-light-emphasis opacity-25' }}" style="transition: transform 0.1s; transform: scale({{ $i === $rating ? '1.1' : '1' }})"></i>
                        </button>
                    @endfor
                </div>
                @error('rating') <span class="text-danger small mt-1 d-block fw-semibold">{{ $message }}</span> @enderror
            </div>

            <!-- Review Content -->
            <div class="col-12">
                <label class="form-label text-uppercase text-muted fw-bold small tracking-wider mb-1">Review Message</label>
                <textarea wire:model="review" rows="4" class="form-control border-light-subtle rounded-3 py-2 text-sm focus-ring" placeholder="Describe your stay, food quality, owner behavior, hygiene..." style="--bs-focus-ring-color: rgba(61, 95, 234, 0.25);"></textarea>
                @error('review') <span class="text-danger small mt-1 d-block fw-semibold">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary w-100 py-2.5 d-flex align-items-center justify-content-center gap-2">
                    <span wire:loading.remove wire:target="submit">Submit Review</span>
                    <span wire:loading wire:target="submit" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span wire:loading wire:target="submit">Submitting...</span>
                </button>
            </div>
        </form>
    @else
        <div class="alert alert-light border border-dashed rounded-3xl text-center py-4 px-3">
            <p class="text-secondary small mb-3">Please sign in to write a review.</p>
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login Now</a>
        </div>
    @endauth
</div>
