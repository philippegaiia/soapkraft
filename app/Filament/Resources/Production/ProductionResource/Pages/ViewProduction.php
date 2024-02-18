<?php

namespace App\Filament\Resources\Production\ProductionResource\Pages;

use App\Filament\Resources\Production\ProductionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProduction extends ViewRecord
{
    protected static string $resource = ProductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
