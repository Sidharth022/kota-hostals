<?php

namespace Database\Seeders;

use App\Models\CoachingCenter;
use Illuminate\Database\Seeder;

class CoachingCenterSeeder extends Seeder
{
    public function run(): void
    {
        $centers = [

            // Allen Buildings
            [
                'title' => 'Allen Samyak',
                'address' => 'Talwandi, Kota',
                'latitude' => 25.1521,
                'longitude' => 75.8661,
            ],
            [
                'title' => 'Allen Sankalp',
                'address' => 'Talwandi, Kota',
                'latitude' => 25.1515,
                'longitude' => 75.8648,
            ],
            [
                'title' => 'Allen Safalya',
                'address' => 'Talwandi, Kota',
                'latitude' => 25.1508,
                'longitude' => 75.8639,
            ],


            // Motion Buildings
            [
                'title' => 'Motion Drona',
                'address' => 'Rajeev Gandhi Nagar, Kota',
                'latitude' => 25.1492,
                'longitude' => 75.8408,
            ],
            [
                'title' => 'Motion Banas',
                'address' => 'Rajeev Gandhi Nagar, Kota',
                'latitude' => 25.1487,
                'longitude' => 75.8425,
            ],

            // Resonance Buildings
            [
                'title' => 'Resonance CG Tower',
                'address' => 'Jhalawar Road, Kota',
                'latitude' => 25.1440,
                'longitude' => 75.8670,
            ],
            [
                'title' => 'Resonance Landmark',
                'address' => 'Landmark City, Kota',
                'latitude' => 25.1452,
                'longitude' => 75.8655,
            ],

            // Others
            [
                'title' => 'Unacademy Kota',
                'address' => 'Vigyan Nagar, Kota',
                'latitude' => 25.1534,
                'longitude' => 75.8601,
            ],
            [
                'title' => 'Vibrant Academy',
                'address' => 'Indra Vihar, Kota',
                'latitude' => 25.1602,
                'longitude' => 75.8521,
            ],
            [
                'title' => 'Aakash Institute',
                'address' => 'Talwandi, Kota',
                'latitude' => 25.1478,
                'longitude' => 75.8445,
            ],
            [
                'title' => 'FIITJEE Kota',
                'address' => 'Swastik Nagar, Kota',
                'latitude' => 25.1522,
                'longitude' => 75.8510,
            ],
            [
                'title' => 'Narayana Academy',
                'address' => 'Mahaveer Nagar, Kota',
                'latitude' => 25.1399,
                'longitude' => 75.8487,
            ],
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