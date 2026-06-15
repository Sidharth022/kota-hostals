<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'KotaHostel') }} | Accommodations in Kota</title>
        <meta name="description" content="{{ $meta_description ?? 'Find the best hostels, PGs, and student accommodations in Kota near major coaching institutes.' }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
        <!-- FontAwesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="{{ asset('assets/style.css') }}">

        @stack('styles')
        @livewireStyles
    </head>
    <body class="d-flex flex-column h-100">
        <!-- Toast Notification Component -->
        <x-toast />

        <!-- Header / Navigation -->
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white border-bottom py-4 mb-4">
                <div class="container">
                    <h1 class="font-outfit fs-3 fw-bold text-dark mb-0">
                        {{ $header }}
                    </h1>
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="flex-shrink-0">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-dark text-light py-5 mt-auto border-top border-secondary">
            <div class="container">
                <div class="row g-4">
                    <!-- Brand info -->
                    <div class="col-12 col-md-4">
                        <a href="/" class="d-flex align-items-center gap-2 font-outfit fs-5 fw-bold text-white text-decoration-none mb-3">
                            <span class="p-2 bg-primary text-white rounded-3 shadow-sm d-inline-flex">
                                <i class="fa-solid fa-building-user fs-6"></i>
                            </span>
                            Kota<span class="text-primary fw-extrabold">Hostel</span>
                        </a>
                        <p class="text-secondary small leading-relaxed">
                            Find premium student hostels and PGs in Kota with real-time room availability, distance-to-coaching details, and honest student reviews.
                        </p>
                    </div>

                    <!-- Hostels by Area -->
                    <div class="col-6 col-md-2">
                        <h6 class="font-outfit fw-bold text-white text-uppercase tracking-wider small mb-3">Popular Areas</h6>
                        <ul class="list-unstyled text-secondary small space-y-2">
                            <li class="mb-2"><a href="/hostels?area=talwandi" class="text-secondary text-decoration-none hover:text-white transition-colors">Talwandi</a></li>
                            <li class="mb-2"><a href="/hostels?area=vigyan-nagar" class="text-secondary text-decoration-none hover:text-white transition-colors">Vigyan Nagar</a></li>
                            <li class="mb-2"><a href="/hostels?area=landmark-city" class="text-secondary text-decoration-none hover:text-white transition-colors">Landmark City</a></li>
                            <li class="mb-2"><a href="/hostels?area=rajeev-gandhi-nagar" class="text-secondary text-decoration-none hover:text-white transition-colors">Rajeev Gandhi Nagar</a></li>
                        </ul>
                    </div>

                    <!-- Information -->
                    <div class="col-6 col-md-3">
                        <h6 class="font-outfit fw-bold text-white text-uppercase tracking-wider small mb-3">Quick Links</h6>
                        <ul class="list-unstyled text-secondary small">
                            <li class="mb-2"><a href="/about" class="text-secondary text-decoration-none hover:text-white transition-colors">About Us</a></li>
                            <li class="mb-2"><a href="/contact" class="text-secondary text-decoration-none hover:text-white transition-colors">Contact Support</a></li>
                            <li class="mb-2"><a href="/faq" class="text-secondary text-decoration-none hover:text-white transition-colors">FAQs</a></li>
                            <li class="mb-2"><a href="/hostels" class="text-secondary text-decoration-none hover:text-white transition-colors">Browse Hostels</a></li>
                        </ul>
                    </div>

                    <!-- Contact & Legal -->
                    <div class="col-12 col-md-3">
                        <h6 class="font-outfit fw-bold text-white text-uppercase tracking-wider small mb-3">Legal & Support</h6>
                        <ul class="list-unstyled text-secondary small">
                            <li class="mb-2"><a href="/privacy-policy" class="text-secondary text-decoration-none hover:text-white transition-colors">Privacy Policy</a></li>
                            <li class="mb-2"><a href="/terms" class="text-secondary text-decoration-none hover:text-white transition-colors">Terms of Service</a></li>
                            <li class="text-muted small mt-2">Support Hours: 9 AM - 6 PM</li>
                            <li class="text-muted small">Email: support@kotahostel.com</li>
                        </ul>
                    </div>
                </div>

                <div class="border-top border-secondary mt-4 pt-4 d-flex flex-col flex-md-row justify-content-between align-items-center text-muted small">
                    <p class="mb-0">&copy; {{ date('Y') }} KotaHostel. All rights reserved.</p>
                    <div class="d-flex gap-3 mt-3 mt-md-0">
                        <a href="#" class="text-muted hover:text-white"><i class="fa-brands fa-facebook fs-5"></i></a>
                        <a href="#" class="text-muted hover:text-white"><i class="fa-brands fa-instagram fs-5"></i></a>
                        <a href="#" class="text-muted hover:text-white"><i class="fa-brands fa-x-twitter fs-5"></i></a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- jQuery & Bootstrap 5 Bundle JS -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        @stack('scripts')
        @livewireScripts
    </body>
</html>
