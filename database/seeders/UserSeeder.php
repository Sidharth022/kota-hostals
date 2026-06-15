<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\OwnerProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Roles
        $superAdminRole = Role::firstOrCreate(['slug' => 'super-admin'], [
            'name' => 'Super Admin',
            'guard_name' => 'web',
            'status' => 'active',
        ]);

        $ownerRole = Role::firstOrCreate(['slug' => 'hostel-owner'], [
            'name' => 'Hostel Owner',
            'guard_name' => 'web',
            'status' => 'active',
        ]);

        $studentRole = Role::firstOrCreate(['slug' => 'student'], [
            'name' => 'Student',
            'guard_name' => 'web',
            'status' => 'active',
        ]);

        // 2. Seed Super Admin User
        $adminUser = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@kotahostel.com',
            'mobile' => '9876543210',
            'password' => Hash::make('password'),
            'role_id' => $superAdminRole->id,
            'status' => 'approved',
            'email_verified_at' => now(),
        ]);
        // Also assign Spatie role for any internal checks
        $adminUser->assignRole($superAdminRole);

        // 3. Seed Hostel Owners
        $owners = [
            ['name' => 'Ramesh Sharma', 'email' => 'ramesh@owner.com', 'mobile' => '9812345671', 'hostel' => 'Sunrise Boys Hostel', 'addr' => '12, Sector 1, Talwandi, Kota'],
            ['name' => 'Priya Singh', 'email' => 'priya@owner.com', 'mobile' => '9812345672', 'hostel' => 'Shree Ganesh Girls Hostel', 'addr' => '45, Sector A, Vigyan Nagar, Kota'],
            ['name' => 'Sunil Gupta', 'email' => 'sunil@owner.com', 'mobile' => '9812345673', 'hostel' => 'Vigyan Nagar Premium PG', 'addr' => '89, Rajeev Gandhi Nagar, Kota'],
            ['name' => 'Anita Verma', 'email' => 'anita@owner.com', 'mobile' => '9812345674', 'hostel' => 'Resonance Zone Girls Hostel', 'addr' => '102, Landmark City, Kota'],
            ['name' => 'Vikram Patel', 'email' => 'vikram@owner.com', 'mobile' => '9812345675', 'hostel' => 'NRI Boys Hostel', 'addr' => '54, Indra Vihar, Kota'],
        ];

        foreach ($owners as $owner) {
            $user = User::create([
                'name' => $owner['name'],
                'email' => $owner['email'],
                'mobile' => $owner['mobile'],
                'password' => Hash::make('password'),
                'role_id' => $ownerRole->id,
                'status' => 'approved',
                'email_verified_at' => now(),
            ]);
            $user->assignRole($ownerRole);

            // Create Owner Profile
            OwnerProfile::create([
                'user_id' => $user->id,
                'hostel_name' => $owner['hostel'],
                'address' => $owner['addr'],
                'city' => 'Kota',
                'state' => 'Rajasthan',
                'gst_number' => '08AAAAA1111A1Z' . rand(1, 9),
                'identity_document' => 'identity_docs/stub.pdf',
                'status' => 'approved',
            ]);
        }

        // 4. Seed Students
        $students = [
            ['name' => 'Arjun Mehta', 'email' => 'arjun@student.com'],
            ['name' => 'Kavya Nair', 'email' => 'kavya@student.com'],
            ['name' => 'Rohit Kumar', 'email' => 'rohit@student.com'],
            ['name' => 'Sneha Patel', 'email' => 'sneha@student.com'],
            ['name' => 'Amit Yadav', 'email' => 'amit@student.com'],
            ['name' => 'Pooja Joshi', 'email' => 'pooja@student.com'],
            ['name' => 'Ravi Shankar', 'email' => 'ravi@student.com'],
            ['name' => 'Divya Sharma', 'email' => 'divya@student.com'],
            ['name' => 'Karan Singh', 'email' => 'karan@student.com'],
            ['name' => 'Meera Reddy', 'email' => 'meera@student.com'],
            ['name' => 'Sanjay Bhat', 'email' => 'sanjay@student.com'],
            ['name' => 'Ananya Das', 'email' => 'ananya@student.com'],
            ['name' => 'Vivek Mishra', 'email' => 'vivek@student.com'],
            ['name' => 'Nisha Tiwari', 'email' => 'nisha@student.com'],
            ['name' => 'Harsh Vardhan', 'email' => 'harsh@student.com'],
            ['name' => 'Shreya Kapoor', 'email' => 'shreya@student.com'],
            ['name' => 'Manish Agarwal', 'email' => 'manish@student.com'],
            ['name' => 'Tanu Rawat', 'email' => 'tanu@student.com'],
            ['name' => 'Dhruv Chauhan', 'email' => 'dhruv@student.com'],
            ['name' => 'Pallavi Soni', 'email' => 'pallavi@student.com'],
        ];

        foreach ($students as $student) {
            $user = User::create([
                'name' => $student['name'],
                'email' => $student['email'],
                'mobile' => '98' . rand(10000000, 99999999),
                'password' => Hash::make('password'),
                'role_id' => $studentRole->id,
                'status' => 'approved',
                'email_verified_at' => now(),
            ]);
            $user->assignRole($studentRole);
        }
    }
}
