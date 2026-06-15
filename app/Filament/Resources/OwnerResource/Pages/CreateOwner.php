<?php

namespace App\Filament\Resources\OwnerResource\Pages;

use App\Filament\Resources\OwnerResource;
use App\Models\Role;
use Filament\Resources\Pages\CreateRecord;

class CreateOwner extends CreateRecord
{
    protected static string $resource = OwnerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $ownerRole = Role::where('slug', 'hostel-owner')->first();
        if ($ownerRole) {
            $data['role_id'] = $ownerRole->id;
        }
        return $data;
    }

    protected function afterCreate(): void
    {
        $ownerRole = Role::where('slug', 'hostel-owner')->first();
        if ($ownerRole) {
            $this->record->assignRole($ownerRole);
        }
    }
}
