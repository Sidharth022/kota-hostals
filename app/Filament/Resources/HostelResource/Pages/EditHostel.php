<?php

namespace App\Filament\Resources\HostelResource\Pages;

use App\Filament\Resources\HostelResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHostel extends EditRecord
{
    protected static string $resource = HostelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
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
