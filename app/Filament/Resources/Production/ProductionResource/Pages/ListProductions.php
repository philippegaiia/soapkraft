<?php

namespace App\Filament\Resources\Production\ProductionResource\Pages;

use Filament\Actions;
use App\Models\Production\Production;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Production\ProductionResource;

class ListProductions extends ListRecords
{
    protected static string $resource = ProductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
          /*  ->after(function (Production $record){
                dd($record);
            })*/,
        ];
    }
}
