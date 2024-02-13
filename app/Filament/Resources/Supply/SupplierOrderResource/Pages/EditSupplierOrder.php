<?php

namespace App\Filament\Resources\Supply\SupplierOrderResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Supply\SupplierOrderResource;

class EditSupplierOrder extends EditRecord
{
    protected static string $resource = SupplierOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->action(function ($data, $record) {
                if ($record->supplier_order_items()->count() > 0) {
                    Notification::make()
                        ->danger()
                        ->title('Opération Impossible')
                        ->body('Cette commande contient des ingrédients commandés. Effacez les pour la supprimer.')
                        ->send();

                    return;
                }

                Notification::make()
                    ->success()
                    ->title('Commande Supprimée')
                    ->body('La Commande ' . $record->order_ref . 'a été supprimée avec succès.')
                    ->send();

                $record->delete();
            }),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
