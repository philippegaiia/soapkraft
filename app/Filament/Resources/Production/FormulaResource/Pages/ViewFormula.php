<?php

namespace App\Filament\Resources\Production\FormulaResource\Pages;

use App\Filament\Resources\Production\FormulaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFormula extends ViewRecord
{
    protected static string $resource = FormulaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
