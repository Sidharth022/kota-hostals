<x-layouts.dashboard>
    <div class="space-y-4">
        <!-- Header info -->
        <div class="mb-4">
            <h4 class="font-outfit fw-bold text-dark mb-1">Welcome back, {{ Auth::user()->name }}!</h4>
            <p class="text-secondary small">Here is a quick overview of your accommodation activity in Kota.</p>
        </div>  

        <!-- Stats Grid (row-cols-1 row-cols-sm-3) -->
        <div class="row g-4 mb-5">
            <!-- Saved Hostels Card -->
            <div class="col">
                <div class="card h-100 border-0 p-4 rounded-3xl d-flex flex-row align-items-center gap-3 shadow-sm bg-light-subtle border border-light-subtle">
                    <div class="d-inline-flex p-3 bg-primary bg-opacity-10 text-primary rounded-xl">
                        <i class="fa-solid fa-heart fs-4"></i>
                    </div>
                    <div>
                        <span class="text-uppercase text-muted fw-bold small d-block" style="font-size: 10px;">Saved Hostels</span>
                        <h4 class="font-outfit fw-bold text-dark mt-1 mb-0">{{ Auth::user()->favorites()->count() }}</h4>
                    </div>
                </div>
            </div>

            <!-- Inquiries Card -->
            <div class="col">
                <div class="card h-100 border-0 p-4 rounded-3xl d-flex flex-row align-items-center gap-3 shadow-sm bg-light-subtle border border-light-subtle">
                    <div class="d-inline-flex p-3 bg-success bg-opacity-10 text-success rounded-xl">
                        <i class="fa-solid fa-envelope fs-4"></i>
                    </div>
                    <div>
                        <span class="text-uppercase text-muted fw-bold small d-block" style="font-size: 10px;">My Inquiries</span>
                        <h4 class="font-outfit fw-bold text-dark mt-1 mb-0">{{ Auth::user()->inquiries()->count() }}</h4>
                    </div>
                </div>
            </div>

            <!-- Reviews Card -->
            <div class="col">
                <div class="card h-100 border-0 p-4 rounded-3xl d-flex flex-row align-items-center gap-3 shadow-sm bg-light-subtle border border-light-subtle">
                    <div class="d-inline-flex p-3 bg-warning bg-opacity-10 text-warning rounded-xl">
                        <i class="fa-solid fa-star fs-4"></i>
                    </div>
                    <div>
                        <span class="text-uppercase text-muted fw-bold small d-block" style="font-size: 10px;">My Reviews</span>
                        <h4 class="font-outfit fw-bold text-dark mt-1 mb-0">{{ Auth::user()->reviews()->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Inquiries Inbox -->
        <div class="border-top border-light-subtle pt-4">
            <h5 class="font-outfit fw-bold text-dark mb-4">Recent Inquiries</h5>
            
            @php
                $recentInquiries = Auth::user()->inquiries()->latest()->limit(5)->get();
            @endphp

            @if($recentInquiries->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle text-sm text-secondary mb-0">
                        <thead class="table-light text-uppercase text-dark font-semibold">
                            <tr>
                                <th class="px-4 py-3 border-0 rounded-start-pill">Hostel</th>
                                <th class="px-4 py-3 border-0">Message</th>
                                <th class="px-4 py-3 border-0">Status</th>
                                <th class="px-4 py-3 border-0 rounded-end-pill">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentInquiries as $inquiry)
                                <tr>
                                    <td class="px-4 py-3 fw-bold text-dark border-0">
                                       {{--  <a href="/hostels/{{ $inquiry->hostel->area->slug }}/{{ $inquiry->hostel->slug }}" class="text-decoration-none text-dark hover-color-primary">
                                       </a> --}}

                                    </td>
                                    <td class="px-4 py-3 border-0 text-muted">{{ $inquiry->message }}</td>
                                    <td class="px-4 py-3 border-0">
                                        <span class="badge px-2.5 py-1 rounded-pill text-xs fw-bold
                                            {{ $inquiry->status === 'new' ? 'bg-danger text-white' : '' }}
                                            {{ $inquiry->status === 'contacted' ? 'bg-warning text-dark' : '' }}
                                            {{ $inquiry->status === 'closed' ? 'bg-success text-white' : '' }}
                                        ">
                                            {{ ucfirst($inquiry->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 border-0">{{ $inquiry->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-light border border-dashed rounded-3xl text-center py-5">
                    <div class="text-muted opacity-25 mb-3">
                        <i class="fa-solid fa-envelope-open-text display-5"></i>
                    </div>
                    <p class="text-secondary small mb-3">No inquiries sent yet.</p>
                    <a href="/hostels" class="btn btn-outline-primary btn-sm">Find a Hostel</a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.dashboard>
