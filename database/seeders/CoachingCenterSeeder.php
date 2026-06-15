<?php

namespace Database\Seeders;

use App\Models\CoachingCenter;
use Illuminate\Database\Seeder;

class CoachingCenterSeeder extends Seeder
{
    public function run(): void
    {
        $centers = [
            ['title' => 'Allen Career Institute', 'address' => 'Allen House, Plot No. 13/2, Bannadewas Scheme, Near Sanskriti School, Kota', 'latitude' => 25.1517, 'longitude' => 75.8658],
            ['title' => 'Motion IIT-JEE', 'address' => '394, Rajeev Gandhi Nagar, Near Ambay Cinema, Kota', 'latitude' => 25.1496, 'longitude' => 75.8412],
            ['title' => 'Resonance', 'address' => 'CG Tower, A-46 & 52, IPIA, Near City Mall, Jhalawar Road, Kota', 'latitude' => 25.1440, 'longitude' => 75.8670],
            ['title' => 'Unacademy Kota', 'address' => 'Vigyan Nagar, Kota', 'latitude' => 25.1534, 'longitude' => 75.8601],
            ['title' => 'Vibrant Academy', 'address' => 'Plot No. B-41, Road No. 2, Near Rawatbhata, Indra Vihar, Kota', 'latitude' => 25.1602, 'longitude' => 75.8521],
            ['title' => 'Aakash Institute', 'address' => 'Plot No. 1, Near Shopping Centre, Talwandi, Kota', 'latitude' => 25.1478, 'longitude' => 75.8445],
            ['title' => 'FIITJEE Kota', 'address' => 'E-9 & 10, Swastik Nagar, Near Vardhman Nagar, Kota', 'latitude' => 25.1522, 'longitude' => 75.8510],
            ['title' => 'Narayana Academy', 'address' => 'C-20, Road No. 1, Mahaveer Nagar II, Kota', 'latitude' => 25.1399, 'longitude' => 75.8487],
        ];

        foreach ($centers as $center) {
            CoachingCenter::create([
                'title' => $center['title'],
                'address' => $center['address'],
                'latitude' => $center['latitude'],
                'longitude' => $center['longitude'],
                'status' => true,
            ]);
        }
    }
}
