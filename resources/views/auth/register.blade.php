<x-guest-layout>
<div class="bg-white p-4 p-md-5 rounded-4 shadow-soft border-0" x-data="{ role: '{{ old('role_type', 'student') === 'hostel-owner' ? 'owner' : 'student' }}', showPw: false, showCpw: false }" style="min-width: 500px">
    <div class="text-center mb-4">
        <h3 class="font-outfit fw-extrabold text-dark mb-1">Create Account</h3>
        <p class="text-secondary small">Join KotaHostel today to find or list student accommodations</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="d-flex flex-column gap-3">
        @csrf
        
        <!-- Bind role_type to backend post -->
        <input type="hidden" name="role_type" :value="role === 'student' ? 'student' : 'hostel-owner'">

        <!-- Role Tab Selector -->
        <div class="auth-tab-group mb-4">
            <button type="button" class="auth-tab-btn" :class="{ 'active': role === 'student' }" @click="role = 'student'">
                <i class="fa-solid fa-user-graduate"></i> Student Register
            </button>
            <button type="button" class="auth-tab-btn" :class="{ 'active': role === 'owner' }" @click="role = 'owner'">
                <i class="fa-solid fa-house-chimney-user"></i> Owner Register
            </button>
        </div>

        <!-- Name -->
        <div>
            <label for="name" class="form-label small fw-semibold text-secondary mb-1">Full Name</label>
            <div class="auth-input-container">
                <span class="auth-input-icon start"><i class="fa-regular fa-user"></i></span>
                <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="John Doe" required autofocus autocomplete="name">
            </div>
            @error('name')
                <div class="text-danger small mt-1" style="font-size: 11px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="form-label small fw-semibold text-secondary mb-1">Email Address</label>
            <div class="auth-input-container">
                <span class="auth-input-icon start"><i class="fa-regular fa-envelope"></i></span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="john@example.com" required autocomplete="username">
            </div>
            @error('email')
                <div class="text-danger small mt-1" style="font-size: 11px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Mobile -->
        <div>
            <label for="mobile" class="form-label small fw-semibold text-secondary mb-1">Mobile Number</label>
            <div class="auth-input-container">
                <span class="auth-input-icon start"><i class="fa-solid fa-phone"></i></span>
                <input id="mobile" type="text" name="mobile" value="{{ old('mobile') }}" class="form-control @error('mobile') is-invalid @enderror" placeholder="10-digit mobile number" required>
            </div>
            @error('mobile')
                <div class="text-danger small mt-1" style="font-size: 11px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Owner Specific Fields: Hostel Name and Address (Toggled by Alpine) -->
        <div x-show="role === 'owner'" x-transition.scale.origin.top style="display: flex; flex-direction: column; gap: 1rem; display: none;">
            <div>
                <label for="hostel_name" class="form-label small fw-semibold text-secondary mb-1">Hostel Name</label>
                <div class="auth-input-container">
                    <span class="auth-input-icon start"><i class="fa-solid fa-hotel"></i></span>
                    <input id="hostel_name" type="text" name="hostel_name" value="{{ old('hostel_name') }}" :required="role === 'owner'" class="form-control @error('hostel_name') is-invalid @enderror" placeholder="e.g. Sunrise Boys Hostel">
                </div>
                @error('hostel_name')
                    <div class="text-danger small mt-1" style="font-size: 11px;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="address" class="form-label small fw-semibold text-secondary mb-1">Hostel Address</label>
                <div class="auth-input-container">
                    <span class="auth-input-icon start"><i class="fa-solid fa-location-dot"></i></span>
                    <textarea id="address" name="address" :required="role === 'owner'" class="form-control @error('address') is-invalid @enderror" placeholder="Complete address of your hostel properties in Kota" rows="2" style="padding-left: 2.75rem !important; height: auto;">{{ old('address') }}</textarea>
                </div>
                @error('address')
                    <div class="text-danger small mt-1" style="font-size: 11px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="form-label small fw-semibold text-secondary mb-1">Password</label>
            <div class="auth-input-container">
                <span class="auth-input-icon start"><i class="fa-solid fa-lock"></i></span>
                <input id="password" :type="showPw ? 'text' : 'password'" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required autocomplete="new-password">
                <span class="auth-input-icon end" @click="showPw = !showPw">
                    <i class="fa-regular" :class="showPw ? 'fa-eye-slash' : 'fa-eye'"></i>
                </span>
            </div>
            @error('password')
                <div class="text-danger small mt-1" style="font-size: 11px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="form-label small fw-semibold text-secondary mb-1">Confirm Password</label>
            <div class="auth-input-container">
                <span class="auth-input-icon start"><i class="fa-solid fa-lock"></i></span>
                <input id="password_confirmation" :type="showCpw ? 'text' : 'password'" name="password_confirmation" class="form-control" placeholder="••••••••" required autocomplete="new-password">
                <span class="auth-input-icon end" @click="showCpw = !showCpw">
                    <i class="fa-regular" :class="showCpw ? 'fa-eye-slash' : 'fa-eye'"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 font-outfit py-2.5 mt-2 rounded-xl">
            Register
        </button>

        <p class="text-center text-secondary small mb-0 mt-3">
            Already registered? 
            <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-semibold">Sign In</a>
        </p>
    </form>
</div>
</x-guest-layout>
