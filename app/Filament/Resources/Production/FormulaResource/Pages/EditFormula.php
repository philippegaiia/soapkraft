<?php

namespace App\Filament\Resources\Production\FormulaResource\Pages;

use App\Filament\Resources\Production\FormulaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFormula extends EditRecord
{
    protected static string $resource = FormulaResource::class;

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
