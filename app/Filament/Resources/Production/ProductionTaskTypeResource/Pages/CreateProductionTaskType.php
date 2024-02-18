<?php

namespace App\Filament\Resources\Production\ProductionTaskTypeResource\Pages;

use App\Filament\Resources\Production\ProductionTaskTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProductionTaskType extends CreateRecord
{
    protected static string $resource = ProductionTaskTypeResource::class;
}
