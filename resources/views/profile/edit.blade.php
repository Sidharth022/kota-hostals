<x-app-layout>
    <div class="container py-5">
        <!-- Header -->
        <div class="mb-5">
            <h1 class="font-outfit fw-extrabold text-dark tracking-tight display-6 mb-2">Profile Settings</h1>
            <p class="text-secondary small">Manage your account information, security credentials, and preferences.</p>
        </div>

        <div class="row g-4">
            <!-- Left Side: Profile Info & Security -->
            <div class="col-12 col-lg-8 d-flex flex-column gap-4">
                <!-- Profile Information Card -->
                <div class="card border-0 shadow-sm p-4 p-md-5 bg-white" style="border-radius: 1.25rem;">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- Update Password Card -->
                <div class="card border-0 shadow-sm p-4 p-md-5 bg-white" style="border-radius: 1.25rem;">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Right Side: Danger Zone -->
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm p-4 bg-white border-top border-danger border-4" style="border-radius: 1.25rem;">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
