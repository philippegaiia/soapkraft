<?php

namespace App\Filament\Resources\Supply\SupplierListingResource\Pages;

use App\Filament\Resources\Supply\SupplierListingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSupplierListing extends EditRecord
{
    protected static string $resource = SupplierListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
