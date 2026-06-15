<?php

namespace Database\Seeders;

use App\Models\Hostel;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::whereHas('role', fn ($q) => $q->where('slug', 'student'))->get();
        $hostels = Hostel::where('status', 'active')->get();

        $reviews = [
            'Excellent hostel! Clean rooms, good food, and very supportive staff. I stayed here during my JEE preparation and got AIR 847.',
            'Good hostel overall. WiFi is fast and reliable. Mess food is decent, though could use more variety on weekends.',
            'Decent accommodation for the price. Slightly noisy at times but manageable. Security is good and warden is helpful.',
            'Amazing experience! This hostel feels like home. The study room environment is fantastic and I highly recommend it.',
            'Value for money hostel. Basic amenities are all covered. The location is very convenient for coaching.',
            'Average hostel. Room maintenance could be better but the price justifies it. Good for budget-conscious students.',
            'Fantastic hostel with great community. Made many friends here. Food is amazing and rooms are very clean.',
            'The hostel has improved a lot in the last year. New management is more responsive. Would recommend it to others.',
            'One of the best hostels in Kota. AC works perfectly, hot water available 24/7, and mess serves healthy food.',
            'Excellent choice for serious students. Strict study environment with no disturbances. CCTV makes it safe.',
        ];

        $usedCombinations = [];

        for ($i = 0; $i < 100; $i++) {
            $student = $students->random();
            $hostel = $hostels->random();

            $combo = "{$student->id}-{$hostel->id}";
            if (in_array($combo, $usedCombinations)) {
                continue;
            }
            $usedCombinations[] = $combo;

            Review::create([
                'user_id' => $student->id,
                'hostel_id' => $hostel->id,
                'rating' => rand(3, 5),
                'review' => $reviews[array_rand($reviews)],
                'status' => 'approved',
                'created_at' => now()->subDays(rand(1, 365)),
            ]);
        }
    }
}
