<?php

namespace App\Filament\Resources\Supply\SupplierResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\viewRecord;
use App\Filament\Resources\Supply\SupplierResource;

class ViewSupplier extends viewRecord
{
    protected static string $resource = SupplierResource::class;

    protected ?string $heading = 'Détails Fournisseur';

}
