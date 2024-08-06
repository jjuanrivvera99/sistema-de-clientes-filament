<?php

namespace App\Filament\Resources\TrashedCustomerResource\Pages;

use App\Filament\Resources\TrashedCustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTrashedCustomer extends CreateRecord
{
    protected static string $resource = TrashedCustomerResource::class;
}
