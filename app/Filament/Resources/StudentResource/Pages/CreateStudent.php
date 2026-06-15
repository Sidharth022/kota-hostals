<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Models\Role;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Automatically assign the student role_id
        $studentRole = Role::where('slug', 'student')->first();
        if ($studentRole) {
            $data['role_id'] = $studentRole->id;
        }
        return $data;
    }

    protected function afterCreate(): void
    {
        $studentRole = Role::where('slug', 'student')->first();
        if ($studentRole) {
            $this->record->assignRole($studentRole);
        }
    }
}
