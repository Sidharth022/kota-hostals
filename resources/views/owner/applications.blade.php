<x-layouts.dashboard>
    <div class="d-flex flex-column gap-4">
        <div>
            <h2 class="font-outfit fs-3 fw-bold text-dark mb-1">Hostel Applications</h2>
            <p class="text-secondary small">Review and manage student admission applications for your hostels.</p>
        </div>

        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show rounded-xl text-sm mb-0" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($applications->count() > 0)
            <div class="d-flex flex-column gap-3">
                @foreach($applications as $application)
                    <div class="card border border-light-subtle rounded-2xl p-4 hover-shadow transition-all bg-white d-flex flex-column gap-3">
                        <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                            <div>
                                <span class="text-uppercase text-primary fw-bold" style="font-size: 10px;">For: {{ $application->hostel->title }}</span>
                                <h5 class="font-outfit fw-bold text-dark mb-0 mt-1">{{ $application->student->name }}</h5>
                            </div>
                            <div>
                                <span class="badge px-2.5 py-1 rounded-pill text-xs fw-bold
                                    {{ $application->status === 'pending' ? 'bg-warning text-dark' : '' }}
                                    {{ $application->status === 'approved' ? 'bg-success text-white' : '' }}
                                    {{ $application->status === 'rejected' ? 'bg-danger text-white' : '' }}
                                    {{ $application->status === 'cancelled' ? 'bg-secondary text-white' : '' }}
                                " style="font-size: 11px;">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Notes/Message -->
                        @if($application->notes)
                            <div class="bg-light bg-opacity-50 border border-light-subtle rounded-xl p-3 text-secondary small italic">
                                "{{ $application->notes }}"
                            </div>
                        @endif

                        <div class="text-muted text-xs border-top border-light-subtle pt-2.5 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3" style="font-size: 11px;">
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <span><i class="fa-solid fa-phone me-1"></i> Mobile: <strong class="text-dark">{{ $application->student->mobile }}</strong></span>
                                <span><i class="fa-regular fa-envelope me-1"></i> Email: <strong class="text-dark">{{ $application->student->email }}</strong></span>
                                <span><i class="fa-regular fa-calendar-days me-1"></i> Joining Date: <strong class="text-dark">{{ $application->joining_date->format('d M Y') }}</strong></span>
                                <span><i class="fa-regular fa-clock me-1"></i> Received: {{ $application->created_at->format('d M Y, h:i A') }}</span>
                            </div>

                            <!-- Actions -->
                            @if($application->status === 'pending')
                                <div class="d-flex gap-2">
                                    <form action="{{ route('owner.applications.status', $application) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-success btn-sm px-3 rounded-pill text-xs fw-semibold">
                                            <i class="fa-solid fa-check me-1"></i> Accept
                                        </button>
                                    </form>
                                    <form action="{{ route('owner.applications.status', $application) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-danger btn-sm px-3 rounded-pill text-xs fw-semibold">
                                            <i class="fa-solid fa-xmark me-1"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 border border-dashed rounded-3xl bg-light bg-opacity-25">
                <div class="text-muted opacity-25 mb-4">
                    <i class="fa-solid fa-file-invoice display-4"></i>
                </div>
                <h4 class="font-outfit fw-bold text-dark">No applications received</h4>
                <p class="text-secondary small max-w-sm mx-auto my-2">Admissions applications sent by students looking to book rooms in your hostels will appear here.</p>
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
