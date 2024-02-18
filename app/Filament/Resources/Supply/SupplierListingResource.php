<?php

namespace App\Filament\Resources\Supply;

use Filament\Forms;
use Filament\Tables;
use App\Enums\Packaging;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Supply\Supplier;
use Filament\Resources\Resource;
use App\Models\Supply\Ingredient;
use Filament\Tables\Actions\ActionGroup;
use App\Models\Supply\SupplierListing;
use Filament\Support\Enums\FontWeight;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Supply\SupplierListingResource\Pages;
use App\Filament\Resources\Supply\SupplierListingResource\RelationManagers;

class SupplierListingResource extends Resource
{
    protected static ?string $model = SupplierListing::class;

    protected static ?string $navigationGroup = 'Achats';

    protected static ?string $navigationLabel = 'Ingrédients référencés';

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('supplier_id')
                    ->relationship('supplier', 'name')
                    ->options(Supplier::all()->pluck('name', 'id'))
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('ingredient_id')
                    ->relationship('ingredient', 'name')
                    ->options(Ingredient::all()->pluck('name', 'id'))
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('code')
                    ->maxLength(255),
                Forms\Components\TextInput::make('supplier_code')
                    ->maxLength(255),
                Forms\Components\Select::make('pkg')
                    ->options(Packaging::class),
                Forms\Components\Select::make('pkg')
                    ->options(Packaging::class),
                Forms\Components\Select::make('unit_of_measure')
                    ->options([
                        'kg' => 'kg',
                        'g' => 'Gramme',
                        'Unit' => 'Unité',
                        'Meter' => 'Mètre',
                        'Litre' => 'Litre',
                    ])
                    ->default('Kilo.'),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('€'),
                Forms\Components\Toggle::make('organic')
                    ->required(),
                Forms\Components\Toggle::make('fairtrade')
                    ->required(),
                Forms\Components\Toggle::make('cosmos')
                    ->required(),
                Forms\Components\Toggle::make('ecocert')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            //->deferLoading()
            ->columns([

                Tables\Columns\TextColumn::make('name')
                    ->label('designation')
                    ->formatStateUsing(fn ($record) => $record->name . ' ' .  $record->unit_weight . ' ' . $record->unit_of_measure)
                    ->weight(FontWeight::Bold)
                    ->searchable(['name', 'unit_of_measure']),

                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('ingredient.name')
                    //->numeric()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('supplier.name')
                    ->numeric()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('pkg')
                    ->label('Packaging')
                    ->toggleable(isToggledHiddenByDefault: true),             

                Tables\Columns\TextColumn::make('unit_weight')
                    ->label('Poids Unit.')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('price')
                    ->label('Prix')
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\IconColumn::make('organic')
                    ->label('Bio')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('fairtrade')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('cosmos')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('ecocert')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Actif')
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
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
            ActionGroup::make([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                ->action(function ($data, $record) {
                    if ($record->supplies()->count() > 0 || $record->supplier_order_items()->count() > 0) {
                        Notification::make()
                            ->danger()
                            ->title('Opération Impossible')
                            ->body('Cet ingrédient est référencé dans des commandes fournisseur et dans les stocks ingrédients.')
                            ->send();

                        return;
                    }

                    Notification::make()
                        ->success()
                        ->title('Fournisseur Supprimé')
                        ->body('Ingrédient ' . $record->name. ' supprimé avec succès.')
                        ->send();

                    $record->delete();
                }),
            ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListSupplierListings::route('/'),
            'create' => Pages\CreateSupplierListing::route('/create'),
            'edit' => Pages\EditSupplierListing::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
