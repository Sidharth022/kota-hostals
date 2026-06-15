<?php

namespace App\Filament\Resources\CoachingCenterResource\Pages;

use App\Filament\Resources\CoachingCenterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCoachingCenters extends ListRecords
{
    protected static string $resource = CoachingCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
