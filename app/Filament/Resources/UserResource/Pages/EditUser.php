<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Handle password change from the "Reseteo de Contraseña" section
        if (! empty($data['new_password'])) {
            $data['password'] = Hash::make($data['new_password']);
        }

        // Remove temporary password fields
        unset($data['new_password'], $data['new_password_confirmation']);

        return $data;
    }
}
