<?php

namespace App\Filament\Resources\HostelApplicationResource\Pages;

use App\Filament\Resources\HostelApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHostelApplication extends EditRecord
{
    protected static string $resource = HostelApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
