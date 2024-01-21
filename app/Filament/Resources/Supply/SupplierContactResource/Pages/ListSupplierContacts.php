<?php

namespace App\Filament\Resources\Supply\SupplierContactResource\Pages;

use App\Filament\Resources\Supply\SupplierContactResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSupplierContacts extends ListRecords
{
    protected static string $resource = SupplierContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
