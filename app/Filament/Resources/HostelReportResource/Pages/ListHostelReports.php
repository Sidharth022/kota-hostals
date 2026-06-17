<?php

namespace App\Filament\Resources\HostelReportResource\Pages;

use App\Filament\Resources\HostelReportResource;
use Filament\Resources\Pages\ListRecords;

class ListHostelReports extends ListRecords
{
    protected static string $resource = HostelReportResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
