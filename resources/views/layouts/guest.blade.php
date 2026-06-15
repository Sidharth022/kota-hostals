<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KotaHostel') }} | Portal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
        <!-- FontAwesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
        <!-- Alpine.js for client-side interactivity -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <style>
            :root {
                --bs-primary: #3D5FEA;
                --bs-primary-rgb: 61, 95, 234;
                --bs-body-bg: #FAFBFD;
                --bs-body-font-family: 'Inter', sans-serif;
            }
            body {
                background-color: var(--bs-body-bg);
                font-family: var(--bs-body-font-family);
                background-image: linear-gradient(135deg, rgba(61, 95, 234, 0.03) 0%, rgba(255,255,255,0) 100%);
            }
            .font-outfit {
                font-family: 'Outfit', sans-serif;
            }
            .card {
                border-radius: 1.25rem !important;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04) !important;
            }
            .btn-primary {
                background-color: var(--bs-primary);
                border-color: var(--bs-primary);
                border-radius: 0.75rem;
                font-weight: 600;
                padding: 0.65rem 1.5rem;
                transition: all 0.2s;
            }
            .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
                background-color: #2a46d6 !important;
                border-color: #2a46d6 !important;
                box-shadow: 0 4px 12px rgba(61, 95, 234, 0.25) !important;
            }
            .form-control {
                border-radius: 0.75rem;
                padding: 0.65rem 1rem;
                border-color: #e2e8f0;
            }
            .form-control:focus {
                border-color: var(--bs-primary);
                box-shadow: 0 0 0 3px rgba(61, 95, 234, 0.1);
            }
            .form-select {
                border-radius: 0.75rem;
                padding: 0.65rem 1rem;
                border-color: #e2e8f0;
            }
            .form-select:focus {
                border-color: var(--bs-primary);
                box-shadow: 0 0 0 3px rgba(61, 95, 234, 0.1);
            }
        </style>
    </head>
    <body class="d-flex flex-column min-vh-100 bg-white pt-0">
        <div class="row g-0 flex-grow-1 min-vh-100-lg">
            <!-- Left Banner Column (Hidden on mobile/tablet, shown on lg and up) -->
            <div class="d-none d-lg-block col-lg-6 col-xl-7 position-relative" style="background-image: url('{{ asset('assets/auth-banner.jpg') }}'); background-size: cover; background-position: center;">
                <!-- Overlay Gradient -->
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-between p-5 text-white" style="background: linear-gradient(135deg, rgba(61, 95, 234, 0.9) 0%, rgba(15, 23, 42, 0.301) 100%);">
                    <!-- Top Brand Logo -->
                    <div>
                        <a href="/" class="d-inline-flex align-items-center gap-2 font-outfit fs-4 fw-bold text-white text-decoration-none">
                            <span class="p-2 bg-white rounded-3 shadow-sm d-inline-flex">
                                <i class="fa-solid fa-building-user fs-5 text-primary-color" style="color: var(--bs-primary) !important;"></i>
                            </span>
                            Kota<span class="text-white fw-extrabold">Hostel</span>
                        </a>
                        <div class="text-white text-opacity-75 small mt-1 ps-1" style="font-size: 11px; letter-spacing: 0.5px;">Find Your Perfect Stay</div>
                    </div>

                    <!-- Middle Content -->
                    <div class="my-auto" style="max-width: 520px; padding-left: 20px;">
                        <h1 class="font-outfit display-5 fw-extrabold text-white mb-3" style="line-height: 1.25;">
                            Find the Best Hostels Near Your Coaching
                        </h1>
                        <p class="text-white text-opacity-75 mb-5 fs-6">
                            Discover comfortable, safe and affordable hostels near Kota's top coaching institutes.
                        </p>

                        <!-- Features List -->
                        <div class="d-flex flex-column gap-4">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-white text-primary rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px; flex-shrink: 0;">
                                    <i class="fa-solid fa-map-location-dot fs-5 text-primary-color" style="color: var(--bs-primary) !important;"></i>
                                </div>
                                <div>
                                    <h6 class="font-outfit fw-bold text-white mb-0">Prime Locations</h6>
                                    <p class="text-white text-opacity-70 small mb-0">Hostels near Allen, Motion, Resonance & more</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-white text-primary rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px; flex-shrink: 0;">
                                    <i class="fa-solid fa-shield-halved fs-5 text-primary-color" style="color: var(--bs-primary) !important;"></i>
                                </div>
                                <div>
                                    <h6 class="font-outfit fw-bold text-white mb-0">Safe & Secure</h6>
                                    <p class="text-white text-opacity-70 small mb-0">Verified listings with 24/7 security</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-white text-primary rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px; flex-shrink: 0;">
                                    <i class="fa-solid fa-indian-rupee-sign fs-5 text-primary-color" style="color: var(--bs-primary) !important;"></i>
                                </div>
                                <div>
                                    <h6 class="font-outfit fw-bold text-white mb-0">Affordable Prices</h6>
                                    <p class="text-white text-opacity-70 small mb-0">Options for every budget and requirement</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Copyright -->
                    <div class="text-white text-opacity-50 small ps-1">
                        &copy; {{ date('Y') }} KotaHostel. All rights reserved.
                    </div>
                </div>
            </div>

            <!-- Right Form Column -->
            <div class="col-12 col-lg-6 col-xl-5 d-flex align-items-center justify-content-center p-4 p-md-5 bg-light min-vh-100">
                <div class="w-100" style="max-width: 440px;">
                    <!-- Brand logo on mobile/tablet (hidden on desktop banner) -->
                    <div class="d-lg-none text-center mb-4">
                        <a href="/" class="d-inline-flex align-items-center gap-2 font-outfit fs-3 fw-bold text-dark text-decoration-none">
                            <span class="p-2 bg-primary text-white rounded-3 shadow-sm d-inline-flex">
                                <i class="fa-solid fa-building-user fs-5"></i>
                            </span>
                            Kota<span class="text-primary fw-extrabold">Hostel</span>
                        </a>
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>

        <!-- jQuery & Bootstrap 5 Bundle JS -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
