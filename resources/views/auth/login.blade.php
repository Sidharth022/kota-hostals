<x-guest-layout>
<div class="bg-white p-4 p-md-5 rounded-4 shadow-soft border-0" x-data="{ role: 'student', showPw: false }" style="min-width: 500px">
    <div class="text-center mb-4">
        <h3 class="font-outfit fw-extrabold text-dark mb-1">Welcome Back!</h3>
        <p class="text-secondary small">Login to your account and continue</p>
    </div>

    <!-- Session Status -->
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show rounded-xl text-sm mb-4" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Role Tab Selector -->
    <div class="auth-tab-group mb-4">
        <button type="button" class="auth-tab-btn" :class="{ 'active': role === 'student' }" @click="role = 'student'">
            <i class="fa-solid fa-user-graduate"></i> Student Login
        </button>
        <button type="button" class="auth-tab-btn" :class="{ 'active': role === 'owner' }" @click="role = 'owner'">
            <i class="fa-solid fa-house-chimney-user"></i> Owner Login
        </button>
    </div>

    <form method="POST" action="{{ route('login') }}" class="d-flex flex-column gap-3">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="form-label small fw-semibold text-secondary mb-1">Email or Mobile Number</label>
            <div class="auth-input-container">
                <span class="auth-input-icon start"><i class="fa-regular fa-user"></i></span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email or mobile number" required autofocus autocomplete="username">
            </div>
            @error('email')
                <div class="text-danger small mt-1" style="font-size: 11px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label small fw-semibold text-secondary mb-0">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-primary text-decoration-none small fw-semibold" style="font-size: 11px;" href="{{ route('password.request') }}">
                        Forgot Password?
                    </a>
                @endif
            </div>
            <div class="auth-input-container">
                <span class="auth-input-icon start"><i class="fa-solid fa-lock"></i></span>
                <input id="password" :type="showPw ? 'text' : 'password'" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" required autocomplete="current-password">
                <span class="auth-input-icon end" @click="showPw = !showPw">
                    <i class="fa-regular" :class="showPw ? 'fa-eye-slash' : 'fa-eye'"></i>
                </span>
            </div>
            @error('password')
                <div class="text-danger small mt-1" style="font-size: 11px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-check text-start">
            <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
            <label for="remember_me" class="form-check-label text-secondary small select-none">Remember Me</label>
        </div>

        <button type="submit" class="btn btn-primary w-100 font-outfit py-2.5 mt-2 rounded-xl">
            Login
        </button>

        <!-- Or continue with divider -->
        <div class="divider-text">or continue with</div>

        <!-- Social logins -->
        <div class="row g-2">
            <div class="col-6">
                <button type="button" class="social-login-btn">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google logo" class="me-2" style="width: 16px; height: 16px;">
                    Google
                </button>
            </div>
            <div class="col-6">
                <button type="button" class="social-login-btn">
                    <i class="fa-brands fa-facebook text-primary me-2" style="font-size: 17px;"></i>
                    Facebook
                </button>
            </div>
        </div>

        <p class="text-center text-secondary small mb-0 mt-4">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-semibold">Register Now</a>
        </p>
    </form>
</div>
</x-guest-layout>
