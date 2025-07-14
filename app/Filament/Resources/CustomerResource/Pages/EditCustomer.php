<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Actions\CommentsAction;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    public function getRecord(): Model
    {
        if ($this->record instanceof Model) {
            $this->record = $this->getModel()::with('membership')->findOrFail($this->record->id);
        }

        return $this->record;
    }

    protected function getHeaderActions(): array
    {
        return [
            CommentsAction::make(),
        ];
    }
}
