<?php

namespace App\Filament\Resources\Supply;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\Supply\Ingredient;
use Filament\Tables\Actions\ActionGroup;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Supply\IngredientResource\Pages;
use App\Filament\Resources\Supply\IngredientResource\RelationManagers;

class IngredientResource extends Resource
{
    protected static ?string $model = Ingredient::class;

    protected static ?string $navigationGroup = 'Achats';

    protected static ?string $navigationLabel = 'Ingrédients';

    protected static ?string $navigationIcon = 'heroicon-m-square-3-stack-3d';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('ingredient_category_id')
                    ->relationship('ingredient_category', 'name')
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->maxLength(255),
                Forms\Components\TextInput::make('name_en')
                    ->maxLength(255),
                Forms\Components\TextInput::make('inci')
                    ->maxLength(255),
                Forms\Components\TextInput::make('inci_naoh')
                    ->maxLength(255),
                Forms\Components\TextInput::make('inci_koh')
                    ->maxLength(255),
                Forms\Components\TextInput::make('cas')
                    ->maxLength(255),
                Forms\Components\TextInput::make('cas_einecs')
                    ->maxLength(255),
                Forms\Components\TextInput::make('einecs')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ingredient_category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name_en')
                    ->searchable(),
                Tables\Columns\TextColumn::make('inci')
                    ->searchable(),
                Tables\Columns\TextColumn::make('inci_naoh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('inci_koh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cas_einecs')
                    ->searchable(),
                Tables\Columns\TextColumn::make('einecs')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
            ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()->action(function ($data, $record) {
                    if ($record->supplier_listings()->count() > 0) {
                        Notification::make()
                            ->danger()
                            ->title('Opération Impossible')
                            ->body('Supprimez les ingrédients référencés liés à l\'ingrédient' . $record->name . ' pour le supprimer.')
                            ->send();
                        return;
                    }

                    Notification::make()
                        ->success()
                        ->title('Ingrédient Supprimé')
                        ->body('L\'ingrédient'  . $record->name . ' a été supprimé avec succès.')
                        ->send();

                    $record->delete();
                }),

            ]),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIngredients::route('/'),
            'create' => Pages\CreateIngredient::route('/create'),
            'edit' => Pages\EditIngredient::route('/{record}/edit'),
        ];
    }
}
