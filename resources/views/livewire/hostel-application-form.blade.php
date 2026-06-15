<div x-data="{ showModal: false }" x-on:application-submitted.window="showModal = false">
    <!-- Apply Now Trigger Button -->
    @auth
        @if(Auth::user()->isStudent())
            <button type="button" @click="showModal = true" class="btn btn-primary w-100 py-2.5 rounded-xl font-outfit fw-bold mt-2 shadow-sm d-flex align-items-center justify-content-center gap-2">
                <i class="fa-solid fa-file-signature"></i>
                <span>Apply For Hostel</span>
            </button>
        @else
            <button type="button" class="btn btn-primary w-100 py-2.5 rounded-xl font-outfit fw-bold mt-2 opacity-50 cursor-not-allowed" disabled>
                Owners / Admins Cannot Apply
            </button>
        @endif
    @else
        <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="btn btn-primary w-100 py-2.5 rounded-xl font-outfit fw-bold mt-2 shadow-sm d-flex align-items-center justify-content-center gap-2">
            <i class="fa-solid fa-right-to-bracket"></i>
            <span>Login to Apply</span>
        </a>
    @endauth

    <!-- Modern Glassmorphic Modal Wrapper -->
    <div x-show="showModal" class="position-fixed top-0 start-0 w-100 h-100 z-3" style="background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(8px); display: flex; align-items: center; justify-content: center; display: none;" x-transition.opacity>
        
        <!-- Modal Container -->
        <div class="card border-0 shadow-lg bg-white p-4 mx-3 w-100"  style="max-width: 500px; border-radius: 1.5rem;" @click.away="showModal = false" x-transition.scale>
            
            <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                <div>
                    <h5 class="font-outfit fw-extrabold text-dark mb-0 fs-5">Apply for Accommodation</h5>
                    <span class="text-secondary small fw-medium">{{ $hostel->title }}</span>
                </div>
                <button type="button" class="btn-close" @click="showModal = false" aria-label="Close"></button>
            </div>

            @if($success_message)
                <div class="alert alert-success rounded-xl text-sm mb-3">
                    <i class="fa-solid fa-circle-check me-2"></i>{{ $success_message }}
                </div>
            @endif

            <form wire:submit.prevent="submit" class="d-flex flex-column gap-3 text-start">
                <!-- Auto filled Student Name -->
                <div>
                    <label class="form-label small fw-semibold text-secondary mb-1">Student Name</label>
                    <input type="text" class="form-control bg-light" value="{{ $name }}" >
                </div>

                <div class="row g-3">
                    <!-- Email -->
                    <div class="col-12 col-sm-6">
                        <label class="form-label small fw-semibold text-secondary mb-1">Email</label>
                        <input type="email" class="form-control bg-light" value="{{ $email }}" >
                    </div>

                    <!-- Mobile -->
                    <div class="col-12 col-sm-6">
                        <label for="app_mobile" class="form-label small fw-semibold text-secondary mb-1">Mobile Number</label>
                        <input type="text" id="app_mobile" wire:model.defer="mobile" class="form-control @error('mobile') is-invalid @enderror" placeholder="10-digit mobile">
                        @error('mobile')
                            <div class="invalid-feedback text-xs mt-1" style="font-size: 11px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Preferred Joining Date -->
                <div>
                    <label for="joining_date" class="form-label small fw-semibold text-secondary mb-1">Preferred Joining Date</label>
                    <input type="date" id="joining_date" wire:model.defer="joining_date" class="form-control @error('joining_date') is-invalid @enderror">
                    @error('joining_date')
                        <div class="invalid-feedback text-xs mt-1" style="font-size: 11px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="form-label small fw-semibold text-secondary mb-1">Preferred Room / Special Notes</label>
                    <textarea id="notes" wire:model.defer="notes" class="form-control @error('notes') is-invalid @enderror" placeholder="Write room preference, joining instructions or comments..." rows="3"></textarea>
                    @error('notes')
                        <div class="invalid-feedback text-xs mt-1" style="font-size: 11px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action buttons -->
                <div class="d-flex align-items-center gap-2 mt-3 justify-content-end">
                    <button type="button" @click="showModal = false" class="btn btn-outline-secondary px-4 rounded-xl text-sm">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-xl text-sm d-flex align-items-center gap-2">
                        <span wire:loading.remove wire:target="submit"><i class="fa-solid fa-paper-plane"></i> Submit Application</span>
                        <span wire:loading wire:target="submit" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span wire:loading wire:target="submit">Submitting...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
