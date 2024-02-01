<?php

namespace App\Filament\Resources\Supply\SupplierOrderResource\Pages;

use App\Filament\Resources\Supply\SupplierOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSupplierOrder extends EditRecord
{
    protected static string $resource = SupplierOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
