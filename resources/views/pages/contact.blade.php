<x-app-layout>
    <x-slot name="title">{{ $page->seo_title ?? $page->title }}</x-slot>
    <x-slot name="meta_description">{{ $page->seo_description }}</x-slot>

    <div class="container py-5">
        <div class="row g-4">
            <!-- Left Info Sidebar (col-lg-4) -->
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-soft p-4 rounded-3xl bg-white h-100 space-y-4">
                    <div class="mb-4">
                        <h2 class="font-outfit fw-bold text-dark mb-1">{{ $page->title }}</h2>
                        <p class="text-muted small">Get in touch with our Kota support team.</p>
                    </div>

                    <div class="d-flex flex-column gap-4">
                        <div class="d-flex align-items-start gap-3">
                            <span class="fs-4 text-primary mt-0.5">📞</span>
                            <div>
                                <strong class="d-block text-dark fw-bold small">Support Helpline</strong>
                                <span class="text-secondary small font-medium">+91 98765 43210</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <span class="fs-4 text-primary mt-0.5">✉️</span>
                            <div>
                                <strong class="d-block text-dark fw-bold small">Email Desk</strong>
                                <span class="text-secondary small font-medium">support@kotahostel.com</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <span class="fs-4 text-primary mt-0.5">📍</span>
                            <div>
                                <strong class="d-block text-dark fw-bold small">Kota Head Office</strong>
                                <span class="text-secondary small font-medium leading-relaxed">
                                    3rd Floor, Landmark Tower,<br>
                                    Rajeev Gandhi Nagar, Kota,<br>
                                    Rajasthan - 324005
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Content & Form (col-lg-8) -->
            <div class="col-12 col-lg-8 space-y-4">
                <!-- Rich text description from CMS page -->
                <div class="card border-0 shadow-soft p-4 rounded-3xl bg-white mb-4">
                    <div class="text-secondary small leading-relaxed">
                        {!! $page->content !!}
                    </div>
                </div>

                <!-- Support Form -->
                <div class="card border-0 shadow-soft p-4 p-md-5 rounded-3xl bg-white">
                    <h5 class="font-outfit fw-bold text-dark mb-4">Send Support Message</h5>
                    
                    <form onsubmit="event.preventDefault(); alert('Thank you! Your support ticket has been received. Our team will contact you shortly.'); this.reset();" class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label class="form-label text-uppercase text-muted fw-bold small tracking-wider mb-1">Full Name</label>
                            <input type="text" required class="form-control border-light-subtle rounded-3 py-2 text-sm focus-ring" placeholder="Enter name" style="--bs-focus-ring-color: rgba(61, 95, 234, 0.25);">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label text-uppercase text-muted fw-bold small tracking-wider mb-1">Mobile Number</label>
                            <input type="tel" required pattern="[0-9]{10}" class="form-control border-light-subtle rounded-3 py-2 text-sm focus-ring" placeholder="10-digit number" style="--bs-focus-ring-color: rgba(61, 95, 234, 0.25);">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-uppercase text-muted fw-bold small tracking-wider mb-1">Email Address</label>
                            <input type="email" required class="form-control border-light-subtle rounded-3 py-2 text-sm focus-ring" placeholder="Enter email" style="--bs-focus-ring-color: rgba(61, 95, 234, 0.25);">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-uppercase text-muted fw-bold small tracking-wider mb-1">Message</label>
                            <textarea required rows="4" class="form-control border-light-subtle rounded-3 py-2 text-sm focus-ring" placeholder="Explain your support query or issue..." style="--bs-focus-ring-color: rgba(61, 95, 234, 0.25);"></textarea>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2.5">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
