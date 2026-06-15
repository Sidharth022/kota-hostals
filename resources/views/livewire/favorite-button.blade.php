<button type="button" wire:click="toggle" class="btn d-inline-flex align-items-center justify-content-center border transition-all rounded-3 p-2.5
    {{ $is_favorite ? 'btn-danger bg-danger-subtle border-danger-subtle text-danger' : 'btn-light border-light-subtle text-secondary' }}
" title="{{ $is_favorite ? 'Remove from Saved' : 'Save Hostel' }}" style="width: 44px; height: 44px;">
    <i class="fa-{{ $is_favorite ? 'solid' : 'regular' }} fa-heart fs-5"></i>
</button>
