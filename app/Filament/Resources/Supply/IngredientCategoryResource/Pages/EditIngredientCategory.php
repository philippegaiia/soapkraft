<?php

namespace App\Filament\Resources\Supply\IngredientCategoryResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Supply\IngredientCategoryResource;

class EditIngredientCategory extends EditRecord
{
    protected static string $resource = IngredientCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->action(function ($data, $record) {
                if ($record->ingredients()->count() > 0) {
                    Notification::make()
                        ->danger()
                        ->title('Opération Impossible')
                        ->body('Supprimez les ingrédients liés à la catégorie' . $record->name . ' pour la supprimer.')
                        ->send();
                    return;
                }

                Notification::make()
                    ->success()
                    ->title('Catégorie ' . $record->name . ' Supprimée')
                    ->body('Le Fournisseur a été supprimé avec succès.')
                    ->send();

                $record->delete();
            }),
        ];
    }
}
