<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\Hostel;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Weights
        Setting::set('weight_coaching', '35');
        Setting::set('weight_medical', '20');
        Setting::set('weight_food', '25');
        Setting::set('weight_study', '20');

        // 2. Add sample distances and hidden costs to existing hostels
        $hostels = Hostel::all();

        foreach ($hostels as $index => $hostel) {
            // Assign reasonable dummy charges
            $hostel->electricity_charges = 500 + (($index % 5) * 150);
            $hostel->laundry_charges = 300 + (($index % 3) * 100);
            $hostel->mess_charges = 1000 + (($index % 4) * 200);
            $hostel->maintenance_charges = 200 + (($index % 2) * 100);
            $hostel->other_charges = ($index % 2 == 0) ? 150 : 0;

            // Assign reasonable dummy distances (in km)
            $hostel->distance_coaching = 0.2 + (($index % 7) * 0.3);
            $hostel->distance_medical = 0.1 + (($index % 5) * 0.4);
            $hostel->distance_hospital = 0.5 + (($index % 6) * 0.5);
            $hostel->distance_library = 0.3 + (($index % 4) * 0.4);
            $hostel->distance_stationery = 0.1 + (($index % 3) * 0.2);
            $hostel->distance_food = 0.2 + (($index % 5) * 0.3);

            // Save the hostel (this will also trigger the saving event to calculate hostel_score)
            $hostel->save();
        }
    }
}
