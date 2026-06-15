<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles required by registration
        \App\Models\Role::create(['name' => 'Student', 'slug' => 'student', 'guard_name' => 'web']);
        \App\Models\Role::create(['name' => 'Hostel Owner', 'slug' => 'hostel-owner', 'guard_name' => 'web']);
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_students_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'mobile' => '9876543210',
            'role_type' => 'student',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        $user = \App\Models\User::where('email', 'student@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('approved', $user->status);
        $this->assertTrue($user->isStudent());
    }

    public function test_new_owners_can_register_as_pending(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Owner',
            'email' => 'owner@example.com',
            'mobile' => '9876543211',
            'role_type' => 'hostel-owner',
            'hostel_name' => 'Kota Palace Hostel',
            'address' => '123, Coaching Area, Kota',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('status', 'Your registration is submitted and pending admin approval. You will be notified via email once approved.');

        $user = \App\Models\User::where('email', 'owner@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('pending', $user->status);
        $this->assertTrue($user->isOwner());

        $profile = $user->ownerProfile;
        $this->assertNotNull($profile);
        $this->assertEquals('Kota Palace Hostel', $profile->hostel_name);
        $this->assertEquals('123, Coaching Area, Kota', $profile->address);
    }
}
