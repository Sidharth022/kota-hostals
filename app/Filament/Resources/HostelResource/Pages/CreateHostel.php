<?php

namespace App\Filament\Resources\HostelResource\Pages;

use App\Filament\Resources\HostelResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHostel extends CreateRecord
{
    protected static string $resource = HostelResource::class;

    protected function afterCreate(): void
    {
        $coachingData = [];
        $repeaterState = $this->data['coaching_centers_repeater'] ?? [];
        foreach ($repeaterState as $item) {
            $centerId = $item['coaching_center_id'] ?? null;
            $distance = $item['distance_km'] ?? null;
            if ($centerId && $distance !== null && $distance !== '') {
                $coachingData[$centerId] = ['distance_km' => (float) $distance];
            }
        }
        $this->record->coachingCenters()->sync($coachingData);
    }
}
