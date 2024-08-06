<?php

namespace App\Filament\Resources\TrashedCustomerResource\Pages;

use App\Filament\Resources\TrashedCustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrashedCustomers extends ListRecords
{
    protected static string $resource = TrashedCustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
