<?php

namespace App\Filament\Resources\Production\ProductionTaskTypeResource\Pages;

use App\Filament\Resources\Production\ProductionTaskTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductionTaskTypes extends ListRecords
{
    protected static string $resource = ProductionTaskTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
