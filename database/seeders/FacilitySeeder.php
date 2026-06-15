<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            ['title' => 'WiFi', 'icon' => 'wifi', 'sort_order' => 1],
            ['title' => 'AC', 'icon' => 'cube-transparent', 'sort_order' => 2],
            ['title' => 'Mess / Canteen', 'icon' => 'cake', 'sort_order' => 3],
            ['title' => 'Laundry', 'icon' => 'archive-box', 'sort_order' => 4],
            ['title' => 'Parking', 'icon' => 'truck', 'sort_order' => 5],
            ['title' => 'CCTV', 'icon' => 'camera', 'sort_order' => 6],
            ['title' => 'Study Room', 'icon' => 'book-open', 'sort_order' => 7],
            ['title' => 'Geyser / Hot Water', 'icon' => 'fire', 'sort_order' => 8],
            ['title' => 'RO Water', 'icon' => 'beaker', 'sort_order' => 9],
            ['title' => 'TV', 'icon' => 'tv', 'sort_order' => 10],
            ['title' => 'Housekeeping', 'icon' => 'sparkles', 'sort_order' => 11],
            ['title' => '24/7 Security', 'icon' => 'shield-check', 'sort_order' => 12],
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}
