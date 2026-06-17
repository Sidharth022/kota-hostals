<div>
    @if($successMessage)
        <div class="alert alert-success d-flex align-items-center gap-2 shadow-sm rounded-3 border-0 py-3 mb-0" role="alert">
            <i class="fa-solid fa-circle-check fs-5"></i>
            <div>{{ $successMessage }}</div>
        </div>
    @else
        <form wire:submit.prevent="submitReport">
            @if(session()->has('error'))
                <div class="alert alert-danger mb-3">{{ session('error') }}</div>
            @endif

            <div class="mb-3">
                <label for="reason" class="form-label small fw-bold text-dark mb-1">Reason for Reporting</label>
                <select id="reason" wire:model="reason" class="form-select @error('reason') is-invalid @enderror">
                    <option value="">Choose a reason...</option>
                    @foreach(\App\Models\HostelReport::$reasons as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('reason')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label small fw-bold text-dark mb-1">Details / Description</label>
                <textarea id="description" wire:model="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="Describe the issue in detail..."></textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-danger px-4 rounded-xl fw-bold d-flex align-items-center gap-2">
                    <span wire:loading wire:target="submitReport" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <i class="fa-solid fa-flag" wire:loading.remove wire:target="submitReport"></i>
                    Submit Complaint
                </button>
            </div>
        </form>
    @endif
</div>
