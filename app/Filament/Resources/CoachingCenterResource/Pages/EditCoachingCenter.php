<?php

namespace App\Filament\Resources\CoachingCenterResource\Pages;

use App\Filament\Resources\CoachingCenterResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCoachingCenter extends EditRecord
{
    protected static string $resource = CoachingCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
