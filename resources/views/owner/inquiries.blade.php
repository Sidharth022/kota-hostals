<x-layouts.dashboard>
    <div class="d-flex flex-column gap-4">
        <div>
            <h2 class="font-outfit fs-3 fw-bold text-dark mb-1">Hostel Inquiries</h2>
            <p class="text-secondary small">Manage and respond to student inquiries for your hostels.</p>
        </div>

        @if($inquiries->count() > 0)
            <div class="d-flex flex-column gap-3">
                @foreach($inquiries as $inquiry)
                    <div class="card border border-light-subtle rounded-2xl p-4 hover-shadow transition-all bg-white d-flex flex-column gap-3">
                        <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                            <div>
                                <span class="text-uppercase text-primary fw-bold" style="font-size: 10px;">For: {{ $inquiry->hostel->title }}</span>
                                <h5 class="font-outfit fw-bold text-dark mb-0 mt-1">{{ $inquiry->name }}</h5>
                            </div>
                            <div>
                                <span class="badge px-2.5 py-1 rounded-pill text-xs fw-bold
                                    {{ $inquiry->status === 'pending' ? 'bg-danger text-white' : '' }}
                                    {{ $inquiry->status === 'responded' ? 'bg-warning text-dark' : '' }}
                                    {{ $inquiry->status === 'closed' ? 'bg-success text-white' : '' }}
                                " style="font-size: 11px;">
                                    {{ ucfirst($inquiry->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Inquiry message -->
                        <div class="bg-light bg-opacity-50 border border-light-subtle rounded-xl p-3 text-secondary small italic">
                            "{{ $inquiry->message }}"
                        </div>

                        <div class="text-muted text-xs border-top border-light-subtle pt-2.5 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3" style="font-size: 11px;">
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <span><i class="fa-solid fa-phone me-1"></i> Mobile: <strong class="text-dark">{{ $inquiry->mobile }}</strong></span>
                                @if($inquiry->email)
                                    <span><i class="fa-regular fa-envelope me-1"></i> Email: <strong class="text-dark">{{ $inquiry->email }}</strong></span>
                                @endif
                                <span><i class="fa-regular fa-calendar-days me-1"></i> Date: {{ $inquiry->created_at->format('d M Y, h:i A') }}</span>
                            </div>

                            <!-- Quick Action Buttons to modify status -->
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-secondary small fw-bold me-2">Mark As:</span>
                                
                                @if($inquiry->status !== 'pending')
                                    <form method="POST" action="{{ route('owner.inquiries.status', $inquiry->id) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="pending">
                                        <button type="submit" class="btn btn-xs btn-outline-danger py-1 px-2.5 rounded fw-bold text-xs" style="font-size: 10px;">Pending</button>
                                    </form>
                                @endif

                                @if($inquiry->status !== 'responded')
                                    <form method="POST" action="{{ route('owner.inquiries.status', $inquiry->id) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="responded">
                                        <button type="submit" class="btn btn-xs btn-outline-warning py-1 px-2.5 rounded fw-bold text-xs" style="font-size: 10px;">Responded</button>
                                    </form>
                                @endif

                                @if($inquiry->status !== 'closed')
                                    <form method="POST" action="{{ route('owner.inquiries.status', $inquiry->id) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="closed">
                                        <button type="submit" class="btn btn-xs btn-outline-success py-1 px-2.5 rounded fw-bold text-xs" style="font-size: 10px;">Closed</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 border border-dashed rounded-3xl bg-light bg-opacity-25">
                <div class="text-muted opacity-25 mb-4">
                    <i class="fa-regular fa-comments display-4"></i>
                </div>
                <h4 class="font-outfit fw-bold text-dark">No inquiries received</h4>
                <p class="text-secondary small max-w-sm mx-auto my-2">Short inquiries sent by students interested in your hostels will appear here.</p>
            </div>
        @endif
    </div>

    <style>
        .hover-shadow:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
        }
        .italic {
            font-style: italic;
        }
    </style>
</x-layouts.dashboard>
