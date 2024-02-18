<?php

namespace App\Filament\Resources\Production\ProductionTaskTypeResource\Pages;

use App\Filament\Resources\Production\ProductionTaskTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProductionTaskType extends ViewRecord
{
    protected static string $resource = ProductionTaskTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
