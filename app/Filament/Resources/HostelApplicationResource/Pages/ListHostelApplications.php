<?php

namespace App\Filament\Resources\HostelApplicationResource\Pages;

use App\Filament\Resources\HostelApplicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHostelApplications extends ListRecords
{
    protected static string $resource = HostelApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
