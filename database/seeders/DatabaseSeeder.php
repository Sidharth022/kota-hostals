<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\CoachingCenter;
use App\Models\Facility;
use App\Models\Favorite;
use App\Models\Hostel;
use App\Models\HostelImage;
use App\Models\Inquiry;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AreaSeeder::class,
            FacilitySeeder::class,
            CoachingCenterSeeder::class,
            UserSeeder::class,
            HostelSeeder::class,
            ReviewSeeder::class,
            InquirySeeder::class,
            PageSeeder::class,
        ]);
    }
}
