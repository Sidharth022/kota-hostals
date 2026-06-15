<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\CoachingCenter;
use App\Models\Facility;
use App\Models\Hostel;
use App\Models\HostelImage;
use App\Models\User;
use Illuminate\Database\Seeder;

class HostelSeeder extends Seeder
{
    public function run(): void
    {
        $owners = User::whereHas('role', fn ($q) => $q->where('slug', 'hostel-owner'))->get();
        $areas = Area::all();
        $facilities = Facility::all();
        $coachingCenters = CoachingCenter::all();

        $hostelData = [
            // Talwandi
            ['title' => 'Sunrise Boys Hostel', 'gender' => 'boys', 'rent' => 7500, 'area' => 'Talwandi', 'verified' => true, 'featured' => true],
            ['title' => 'Allen Adjacent Boys PG', 'gender' => 'boys', 'rent' => 9000, 'area' => 'Talwandi', 'verified' => true, 'featured' => true],
            ['title' => 'Shree Ganesh Girls Hostel', 'gender' => 'girls', 'rent' => 8000, 'area' => 'Talwandi', 'verified' => true, 'featured' => false],
            ['title' => 'Scholar\'s Nest Co-ed', 'gender' => 'coed', 'rent' => 6500, 'area' => 'Talwandi', 'verified' => false, 'featured' => false],
            ['title' => 'Kota Comfort Boys Hostel', 'gender' => 'boys', 'rent' => 5500, 'area' => 'Talwandi', 'verified' => true, 'featured' => false],

            // Vigyan Nagar
            ['title' => 'Vigyan Nagar Premium PG', 'gender' => 'boys', 'rent' => 12000, 'area' => 'Vigyan Nagar', 'verified' => true, 'featured' => true],
            ['title' => 'Resonance Zone Girls Hostel', 'gender' => 'girls', 'rent' => 10000, 'area' => 'Vigyan Nagar', 'verified' => true, 'featured' => true],
            ['title' => 'Motion Adjacent Boys PG', 'gender' => 'boys', 'rent' => 11000, 'area' => 'Vigyan Nagar', 'verified' => true, 'featured' => false],
            ['title' => 'Study Hub Co-ed Hostel', 'gender' => 'coed', 'rent' => 8500, 'area' => 'Vigyan Nagar', 'verified' => false, 'featured' => false],
            ['title' => 'IIT Dreams Boys Hostel', 'gender' => 'boys', 'rent' => 9500, 'area' => 'Vigyan Nagar', 'verified' => true, 'featured' => false],

            // Rajeev Gandhi Nagar
            ['title' => 'RGN Boys Hostel', 'gender' => 'boys', 'rent' => 6500, 'area' => 'Rajeev Gandhi Nagar', 'verified' => true, 'featured' => false],
            ['title' => 'Sapna Girls PG', 'gender' => 'girls', 'rent' => 7000, 'area' => 'Rajeev Gandhi Nagar', 'verified' => true, 'featured' => false],
            ['title' => 'Student Hub Hostel', 'gender' => 'coed', 'rent' => 5500, 'area' => 'Rajeev Gandhi Nagar', 'verified' => false, 'featured' => false],
            ['title' => 'Green Valley Boys Hostel', 'gender' => 'boys', 'rent' => 7500, 'area' => 'Rajeev Gandhi Nagar', 'verified' => true, 'featured' => false],
            ['title' => 'Lotus Girls Hostel', 'gender' => 'girls', 'rent' => 8500, 'area' => 'Rajeev Gandhi Nagar', 'verified' => true, 'featured' => true],

            // Indra Vihar
            ['title' => 'Indra Boys Hostel', 'gender' => 'boys', 'rent' => 5000, 'area' => 'Indra Vihar', 'verified' => false, 'featured' => false],
            ['title' => 'Vibrant Adjacent Girls PG', 'gender' => 'girls', 'rent' => 6500, 'area' => 'Indra Vihar', 'verified' => true, 'featured' => false],
            ['title' => 'Budget Boys Hostel', 'gender' => 'boys', 'rent' => 4500, 'area' => 'Indra Vihar', 'verified' => false, 'featured' => false],
            ['title' => 'Janki Girls Hostel', 'gender' => 'girls', 'rent' => 5500, 'area' => 'Indra Vihar', 'verified' => true, 'featured' => false],
            ['title' => 'NRI Boys Hostel', 'gender' => 'boys', 'rent' => 14000, 'area' => 'Indra Vihar', 'verified' => true, 'featured' => true],

            // Mahaveer Nagar
            ['title' => 'Mahaveer Boys PG', 'gender' => 'boys', 'rent' => 7000, 'area' => 'Mahaveer Nagar', 'verified' => true, 'featured' => false],
            ['title' => 'Shanti Girls Hostel', 'gender' => 'girls', 'rent' => 7500, 'area' => 'Mahaveer Nagar', 'verified' => true, 'featured' => false],
            ['title' => 'Narayana Adjacent Boys Hostel', 'gender' => 'boys', 'rent' => 8000, 'area' => 'Mahaveer Nagar', 'verified' => true, 'featured' => false],
            ['title' => 'Comfort Co-ed PG', 'gender' => 'coed', 'rent' => 6000, 'area' => 'Mahaveer Nagar', 'verified' => false, 'featured' => false],
            ['title' => 'Elite Girls Hostel', 'gender' => 'girls', 'rent' => 11000, 'area' => 'Mahaveer Nagar', 'verified' => true, 'featured' => true],

            // Jawahar Nagar
            ['title' => 'Jawahar Boys Hostel', 'gender' => 'boys', 'rent' => 5500, 'area' => 'Jawahar Nagar', 'verified' => false, 'featured' => false],
            ['title' => 'New Boys PG Jawahar', 'gender' => 'boys', 'rent' => 6000, 'area' => 'Jawahar Nagar', 'verified' => true, 'featured' => false],
            ['title' => 'Affordable Girls Hostel', 'gender' => 'girls', 'rent' => 5000, 'area' => 'Jawahar Nagar', 'verified' => false, 'featured' => false],

            // Dadabari
            ['title' => 'Dadabari Student Hostel', 'gender' => 'boys', 'rent' => 4800, 'area' => 'Dadabari', 'verified' => false, 'featured' => false],
            ['title' => 'Modern Girls PG Dadabari', 'gender' => 'girls', 'rent' => 5500, 'area' => 'Dadabari', 'verified' => true, 'featured' => false],

            // Nayapura
            ['title' => 'Central Boys Hostel', 'gender' => 'boys', 'rent' => 8000, 'area' => 'Nayapura', 'verified' => true, 'featured' => false],
            ['title' => 'Prime Location Girls PG', 'gender' => 'girls', 'rent' => 9000, 'area' => 'Nayapura', 'verified' => true, 'featured' => true],
            ['title' => 'All India Rankers Hostel', 'gender' => 'boys', 'rent' => 13000, 'area' => 'Nayapura', 'verified' => true, 'featured' => true],

            // Borkhera
            ['title' => 'Borkhera Budget PG', 'gender' => 'boys', 'rent' => 4000, 'area' => 'Borkhera', 'verified' => false, 'featured' => false],
            ['title' => 'Peaceful Girls Hostel Borkhera', 'gender' => 'girls', 'rent' => 4500, 'area' => 'Borkhera', 'verified' => false, 'featured' => false],

            // Kunhari
            ['title' => 'Kunhari Boys Hostel', 'gender' => 'boys', 'rent' => 5000, 'area' => 'Kunhari', 'verified' => false, 'featured' => false],
            ['title' => 'Quiet Study Girls PG', 'gender' => 'girls', 'rent' => 5500, 'area' => 'Kunhari', 'verified' => true, 'featured' => false],

            // Vigyan Nagar extra
            ['title' => 'Premium AC Boys Hostel', 'gender' => 'boys', 'rent' => 15000, 'area' => 'Vigyan Nagar', 'verified' => true, 'featured' => true],
            ['title' => 'Kota Grand Girls Hostel', 'gender' => 'girls', 'rent' => 13000, 'area' => 'Vigyan Nagar', 'verified' => true, 'featured' => true],
            ['title' => 'Engineer\'s Den Boys PG', 'gender' => 'boys', 'rent' => 9500, 'area' => 'Vigyan Nagar', 'verified' => true, 'featured' => false],
            ['title' => 'Doctor\'s Choice Girls Hostel', 'gender' => 'girls', 'rent' => 10500, 'area' => 'Vigyan Nagar', 'verified' => true, 'featured' => false],
            ['title' => 'Topper\'s Hostel', 'gender' => 'boys', 'rent' => 11500, 'area' => 'Rajeev Gandhi Nagar', 'verified' => true, 'featured' => true],

            // Talwandi extra
            ['title' => 'Galaxy Boys Hostel', 'gender' => 'boys', 'rent' => 7800, 'area' => 'Talwandi', 'verified' => true, 'featured' => false],
            ['title' => 'Diamond Girls PG', 'gender' => 'girls', 'rent' => 8200, 'area' => 'Talwandi', 'verified' => true, 'featured' => false],
            ['title' => 'Star Boys Hostel', 'gender' => 'boys', 'rent' => 6800, 'area' => 'Talwandi', 'verified' => false, 'featured' => false],
            ['title' => 'Saffron Girls Hostel', 'gender' => 'girls', 'rent' => 7200, 'area' => 'Indra Vihar', 'verified' => true, 'featured' => false],
            ['title' => 'Happy Home Co-ed Hostel', 'gender' => 'coed', 'rent' => 6200, 'area' => 'Mahaveer Nagar', 'verified' => false, 'featured' => false],
        ];

        $descriptions = [
            'A comfortable and well-maintained hostel ideal for JEE and NEET aspirants. Features spacious rooms, nutritious mess food, and 24/7 security.',
            'Premium student accommodation with modern amenities. Study-friendly environment with dedicated reading rooms and reliable WiFi connectivity.',
            'Budget-friendly hostel offering clean rooms, healthy meals, and a supportive community of students from across India.',
            'Strategically located near major coaching institutes, this hostel provides everything a student needs for focused preparation.',
            'A home away from home for serious students. Our strict no-disturbance policy ensures maximum concentration during study hours.',
            'Top-rated student hostel in Kota with modern facilities, delicious food, and an environment that has produced countless IIT and medical toppers.',
            'Fully furnished rooms with 24/7 power backup, RO water, and experienced wardens who understand student needs.',
        ];

        foreach ($hostelData as $index => $data) {
            $area = $areas->firstWhere('title', $data['area']);
            $owner = $owners->random();

            $hostel = Hostel::create([
                'owner_id' => $owner->id,
                'area_id' => $area->id,
                'title' => $data['title'],
                'description' => $descriptions[array_rand($descriptions)],
                'address' => $data['title'] . ', ' . $data['area'] . ', Kota, Rajasthan 324005',
                'latitude' => 25.1400 + (rand(-100, 200) / 10000),
                'longitude' => 75.8400 + (rand(-100, 200) / 10000),
                'monthly_rent' => $data['rent'],
                'security_deposit' => $data['rent'] * 2,
                'room_types' => $this->getRoomTypes($data['gender']),
                'gender_type' => $data['gender'],
                'total_rooms' => rand(15, 60),
                'available_rooms' => rand(2, 15),
                'featured' => $data['featured'],
                'verified' => $data['verified'],
                'status' => 'active',
                'views' => rand(50, 5000),
            ]);

            // Attach 3-8 random facilities
            $hostel->facilities()->attach(
                $facilities->random(rand(3, 8))->pluck('id')->toArray()
            );

            // Attach 2-4 coaching centers with distances
            $selectedCenters = $coachingCenters->random(rand(2, 4));
            foreach ($selectedCenters as $center) {
                $hostel->coachingCenters()->attach($center->id, [
                    'distance_km' => round(rand(2, 30) / 10, 1), // 0.2–3.0 km
                ]);
            }
        }
    }

    private function getRoomTypes(string $gender): array
    {
        $types = ['single', 'double', 'triple'];
        return array_slice($types, 0, rand(1, 3));
    }
}
