<?php

namespace App\Filament\Resources\Supply\SupplierResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Supply\SupplierResource;

class EditSupplier extends EditRecord
{
    protected static string $resource = SupplierResource::class;

    protected ?string $heading = 'Modifier Fournisseur';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->action(function ($data, $record) {
                if ($record->contacts()->count() > 0 || $record->supplier_listings()->count() > 0) {
                    Notification::make()
                        ->danger()
                        ->title('Opération Impossible')
                        ->body('Supprimez les fichiers liés à ce fournisseur pour le supprimer.')
                        ->send();

                    return;
                }
                    Notification::make()
                        ->success()
                        ->title('Fournisseur Supprimé')
                        ->body('Le Fournisseur a été supprimé avec succès.')
                        ->send();

                    $record->delete();
                }),
        ];
    }
}
