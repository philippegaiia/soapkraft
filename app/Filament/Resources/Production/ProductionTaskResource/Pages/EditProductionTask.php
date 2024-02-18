<?php

namespace App\Filament\Resources\Production\ProductionTaskResource\Pages;

use App\Filament\Resources\Production\ProductionTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductionTask extends EditRecord
{
    protected static string $resource = ProductionTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
