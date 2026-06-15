<div class="bg-white p-4 p-md-5 rounded-4 shadow-soft border-0" x-data="{ showPw: false }">
    <div class="text-center mb-4">
        <h3 class="font-outfit fw-extrabold text-dark mb-1">Admin Portal</h3>
        <p class="text-secondary small">Login to manage KotaHostel</p>
    </div>

    <!-- Session Status / Errors -->
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show rounded-xl text-sm mb-4" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form wire:submit="authenticate" class="d-flex flex-column gap-3">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="form-label small fw-semibold text-secondary mb-1">Email Address</label>
            <div class="auth-input-container">
                <span class="auth-input-icon start"><i class="fa-regular fa-user"></i></span>
                <input id="email" type="email" wire:model="data.email" class="form-control @error('data.email') is-invalid @enderror" placeholder="Enter admin email" required autofocus autocomplete="username">
            </div>
            @error('data.email')
                <div class="text-danger small mt-1" style="font-size: 11px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label small fw-semibold text-secondary mb-0">Password</label>
            </div>
            <div class="auth-input-container">
                <span class="auth-input-icon start"><i class="fa-solid fa-lock"></i></span>
                <input id="password" :type="showPw ? 'text' : 'password'" wire:model="data.password" class="form-control @error('data.password') is-invalid @enderror" placeholder="Enter password" required autocomplete="current-password">
                <span class="auth-input-icon end" @click="showPw = !showPw">
                    <i class="fa-regular" :class="showPw ? 'fa-eye-slash' : 'fa-eye'"></i>
                </span>
            </div>
            @error('data.password')
                <div class="text-danger small mt-1" style="font-size: 11px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-check text-start">
            <input id="remember" type="checkbox" wire:model="data.remember" class="form-check-input">
            <label for="remember" class="form-check-label text-secondary small select-none">Remember Me</label>
        </div>

        <button type="submit" class="btn btn-primary w-100 font-outfit py-2.5 mt-2 rounded-xl">
            Login
        </button>
    </form>
</div>
