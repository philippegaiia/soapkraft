<?php

namespace App\Filament\Resources\Production\ProducttagResource\Pages;

use App\Filament\Resources\Production\ProducttagResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProducttag extends EditRecord
{
    protected static string $resource = ProducttagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
