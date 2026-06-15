@if ($paginator->hasPages())
    <nav class="d-flex flex-column align-items-center gap-3">
        <!-- Page navigation -->
        <ul class="pagination mb-0 gap-1 border-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link rounded-circle border-0 d-flex align-items-center justify-content-center text-muted" style="width: 38px; height: 38px; background-color: #f1f3f9;"><i class="fa-solid fa-chevron-left text-xs"></i></span>
                </li>
            @else
                <li class="page-item">
                    <button type="button" wire:click="previousPage" wire:loading.attr="disabled" class="page-link rounded-circle border-0 d-flex align-items-center justify-content-center text-primary" style="width: 38px; height: 38px; background-color: #eef2ff;" rel="prev"><i class="fa-solid fa-chevron-left text-xs"></i></button>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link rounded-circle border-0 d-flex align-items-center justify-content-center text-muted" style="width: 38px; height: 38px; background-color: #f1f3f9;">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link rounded-circle border-0 d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 38px; height: 38px; background-color: var(--bs-primary);">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <button type="button" wire:click="gotoPage({{ $page }})" class="page-link rounded-circle border-0 d-flex align-items-center justify-content-center text-dark fw-medium" style="width: 38px; height: 38px; background-color: #f8fafc;" onmouseover="this.style.backgroundColor='#eef2ff'; this.style.color='var(--bs-primary)';" onmouseout="this.style.backgroundColor='#f8fafc'; this.style.color='#212529';">{{ $page }}</button>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <button type="button" wire:click="nextPage" wire:loading.attr="disabled" class="page-link rounded-circle border-0 d-flex align-items-center justify-content-center text-primary" style="width: 38px; height: 38px; background-color: #eef2ff;" rel="next"><i class="fa-solid fa-chevron-right text-xs"></i></button>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link rounded-circle border-0 d-flex align-items-center justify-content-center text-muted" style="width: 38px; height: 38px; background-color: #f1f3f9;"><i class="fa-solid fa-chevron-right text-xs"></i></span>
                </li>
            @endif
        </ul>

        <!-- Results counter -->
        <div class="text-secondary small fw-medium">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>
    </nav>
@endif
