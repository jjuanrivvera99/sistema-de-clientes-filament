<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\CustomerResource;
use Parallax\FilamentComments\Actions\CommentsAction;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    public function getRecord(): Model
    {
        $this->record = $this->getModel()::with('membership')->findOrFail($this->record->id);

        return $this->record;
    }

    protected function getHeaderActions(): array
    {
        return [
            CommentsAction::make(),
        ];
    }
}
