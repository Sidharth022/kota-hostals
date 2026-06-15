<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            ['title' => 'Talwandi', 'description' => 'Popular area near Allen coaching, home to many student hostels.', 'sort_order' => 1],
            ['title' => 'Rajeev Gandhi Nagar', 'description' => 'Well-connected residential area preferred by JEE aspirants.', 'sort_order' => 2],
            ['title' => 'Indra Vihar', 'description' => 'Affordable area with good transport links to coaching institutes.', 'sort_order' => 3],
            ['title' => 'Vigyan Nagar', 'description' => 'Premium locality close to Motion and Resonance centers.', 'sort_order' => 4],
            ['title' => 'Mahaveer Nagar', 'description' => 'Established residential zone with quality PG accommodations.', 'sort_order' => 5],
            ['title' => 'Jawahar Nagar', 'description' => 'Affordable student-friendly area with multiple food options.', 'sort_order' => 6],
            ['title' => 'Dadabari', 'description' => 'Growing locality with new hostel constructions for students.', 'sort_order' => 7],
            ['title' => 'Borkhera', 'description' => 'Outskirts area offering budget-friendly student accommodation.', 'sort_order' => 8],
            ['title' => 'Kunhari', 'description' => 'Peaceful residential area suitable for focused study.', 'sort_order' => 9],
            ['title' => 'Nayapura', 'description' => 'Central area with easy access to all major coaching institutes.', 'sort_order' => 10],
        ];

        foreach ($areas as $area) {
            Area::create([
                'title' => $area['title'],
                'description' => $area['description'],
                'sort_order' => $area['sort_order'],
                'status' => true,
            ]);
        }
    }
}
