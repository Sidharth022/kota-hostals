<div class="card border-0 shadow-soft p-4 rounded-3xl bg-white">
    <h5 class="font-outfit fw-bold text-dark mb-1">Send Inquiry</h5>
    <p class="text-muted small mb-4">Hostel owner will contact you directly to share details.</p>

    <form wire:submit.prevent="submit" class="row g-3">
        <!-- Name -->
        <div class="col-12">
            <label class="form-label text-uppercase text-muted fw-bold small tracking-wider mb-1">Your Name</label>
            <input type="text" wire:model="name" class="form-control border-light-subtle rounded-3 py-2 text-sm focus-ring" placeholder="Enter your name" style="--bs-focus-ring-color: rgba(61, 95, 234, 0.25);">
            @error('name') <span class="text-danger small mt-1 d-block fw-semibold">{{ $message }}</span> @enderror
        </div>

        <!-- Email -->
        <div class="col-12">
            <label class="form-label text-uppercase text-muted fw-bold small tracking-wider mb-1">Email Address</label>
            <input type="email" wire:model="email" class="form-control border-light-subtle rounded-3 py-2 text-sm focus-ring" placeholder="Enter your email" style="--bs-focus-ring-color: rgba(61, 95, 234, 0.25);">
            @error('email') <span class="text-danger small mt-1 d-block fw-semibold">{{ $message }}</span> @enderror
        </div>

        <!-- Mobile -->
        <div class="col-12">
            <label class="form-label text-uppercase text-muted fw-bold small tracking-wider mb-1">Mobile Number</label>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted small fw-bold">+91</span>
                <input type="tel" wire:model="mobile" class="form-control border-light-subtle rounded-3 py-2 text-sm focus-ring" placeholder="9876543210" style="--bs-focus-ring-color: rgba(61, 95, 234, 0.25);">
            </div>
            @error('mobile') <span class="text-danger small mt-1 d-block fw-semibold">{{ $message }}</span> @enderror
        </div>

        <!-- Message -->
        <div class="col-12">
            <label class="form-label text-uppercase text-muted fw-bold small tracking-wider mb-1">Message / Requirements</label>
            <textarea wire:model="message" rows="3" class="form-control border-light-subtle rounded-3 py-2 text-sm focus-ring" placeholder="I am looking for a single room from next month..." style="--bs-focus-ring-color: rgba(61, 95, 234, 0.25);"></textarea>
            @error('message') <span class="text-danger small mt-1 d-block fw-semibold">{{ $message }}</span> @enderror
        </div>

        <!-- Submit Button -->
        <div class="col-12 mt-4">
            <button type="submit" class="btn btn-primary w-100 py-2.5 d-flex align-items-center justify-content-center gap-2">
                <span wire:loading.remove wire:target="submit">Submit Inquiry</span>
                <span wire:loading wire:target="submit" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span wire:loading wire:target="submit">Sending...</span>
            </button>
        </div>
    </form>
</div>
