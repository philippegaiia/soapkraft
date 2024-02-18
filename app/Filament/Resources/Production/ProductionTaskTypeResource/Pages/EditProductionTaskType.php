<?php

namespace App\Filament\Resources\Production\ProductionTaskTypeResource\Pages;

use App\Filament\Resources\Production\ProductionTaskTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductionTaskType extends EditRecord
{
    protected static string $resource = ProductionTaskTypeResource::class;

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
