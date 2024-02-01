<?php

namespace App\Filament\Resources\Supply\SupplierOrderResource\Pages;

use App\Filament\Resources\Supply\SupplierOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSupplierOrders extends ListRecords
{
    protected static string $resource = SupplierOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
