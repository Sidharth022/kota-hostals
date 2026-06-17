<?php

namespace App\Filament\Resources\HostelReportResource\Pages;

use App\Filament\Resources\HostelReportResource;
use Filament\Resources\Pages\EditRecord;

class EditHostelReport extends EditRecord
{
    protected static string $resource = HostelReportResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function afterSave(): void
    {
        if ($this->record->hostel) {
            \App\Jobs\RecalculateHostelScore::dispatch($this->record->hostel);
        }
    }
}
