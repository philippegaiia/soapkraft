<?php

namespace App\Filament\Resources\Supply\SupplierListingResource\Pages;

use App\Filament\Resources\Supply\SupplierListingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSupplierListings extends ListRecords
{
    protected static string $resource = SupplierListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
