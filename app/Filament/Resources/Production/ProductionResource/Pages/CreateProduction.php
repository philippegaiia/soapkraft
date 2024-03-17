<?php

namespace App\Filament\Resources\Production\ProductionResource\Pages;

use Filament\Actions;
use Illuminate\Http\Request;
use App\Models\Production\Production;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Production\ProductionResource;

class CreateProduction extends CreateRecord
{
    protected static string $resource = ProductionResource::class;

}
