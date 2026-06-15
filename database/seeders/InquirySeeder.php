<?php

namespace Database\Seeders;

use App\Models\Hostel;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Database\Seeder;

class InquirySeeder extends Seeder
{
    public function run(): void
    {
        $students = User::whereHas('role', fn ($q) => $q->where('slug', 'student'))->get();
        $hostels = Hostel::where('status', 'active')->get();

        $messages = [
            'I am interested in a double room. Please let me know the availability and if there are any discounts available for long-term stays.',
            'Looking for accommodation near Allen coaching. Is this hostel still available? What are the meal timings?',
            'Can you please share the room photos? Also, is there a provision for home delivery of food during exam time?',
            'My parents will be visiting next month. Can we visit the hostel before booking? What documents are required for admission?',
            'I need a quiet room for studying. Do you have single occupancy rooms available from next month?',
            'Interested in booking a room for the upcoming academic session starting in April. Please confirm vacancy.',
            'What is the WiFi speed? I need reliable internet for online classes. Also, is the hostel near the bus stand?',
            'Looking for a room for 2 students. Can we get an adjoining room or a double sharing accommodation?',
        ];

        $statuses = ['new', 'new', 'new', 'contacted', 'contacted', 'closed'];

        for ($i = 0; $i < 80; $i++) {
            $student = $students->random();
            $hostel = $hostels->random();

            Inquiry::create([
                'student_id' => rand(0, 1) ? $student->id : null,
                'hostel_id' => $hostel->id,
                'name' => $student->name,
                'email' => $student->email,
                'mobile' => '98' . rand(10000000, 99999999),
                'message' => $messages[array_rand($messages)],
                'status' => $statuses[array_rand($statuses)],
                'created_at' => now()->subDays(rand(1, 180)),
            ]);
        }
    }
}
