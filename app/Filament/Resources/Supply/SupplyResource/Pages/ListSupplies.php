<?php

namespace App\Filament\Resources\Supply\SupplyResource\Pages;

use App\Filament\Resources\Supply\SupplyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSupplies extends ListRecords
{
    protected static string $resource = SupplyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
