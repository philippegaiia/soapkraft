<?php

namespace App\Filament\Resources\Supply;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Supply\Supply;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Supply\SupplyResource\Pages;
use App\Filament\Resources\Supply\SupplyResource\RelationManagers;

class SupplyResource extends Resource
{
    protected static ?string $model = Supply::class;

    protected static ?string $navigationGroup = 'Achats';

    protected static ?string $navigationLabel = 'Inventaire';

    protected static ?string $navigationIcon = 'heroicon-c-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('supplier_listing_id')
                    ->label('Ingrédient')
                    ->relationship('supplier_listing', 'name')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} {$record->unit_weight}kg {$record->unit_of_mesure} - {$record->supplier->name}")
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\TextInput::make('order_ref')
                    ->maxLength(255),

                Forms\Components\TextInput::make('batch_number')
                    ->maxLength(255),

                Forms\Components\TextInput::make('initial_quantity')
                    ->numeric(),

                Forms\Components\TextInput::make('quantity_in')
                    ->numeric(),

                Forms\Components\TextInput::make('quantity_out')
                    ->numeric(),

                Forms\Components\TextInput::make('unit_price')
                    ->numeric(),

                Forms\Components\DatePicker::make('expiry_date'),
                Forms\Components\DatePicker::make('delivery_date'),
                Forms\Components\ToggleButtons::make('is_in_stock')
                    ->label('En stock')
                    ->inline(false)
                    ->boolean()
                    ->grouped(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('supplier_listing.name')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('supplier_listing.ingredient.name')
                    ->label('Ingrédient')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('order_ref')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('batch_number')
                    ->searchable(),

                Tables\Columns\TextColumn::make('initial_quantity')
                    ->label('Stock initial')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantity_in')
                    ->label('Stock IN')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantity_out')
                    ->label('Stock OUT')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit_price')
                    ->label('Prix Unitaire')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('expiry_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('delivery_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_in_stock')
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSupplies::route('/'),
            'create' => Pages\CreateSupply::route('/create'),
            'view' => Pages\ViewSupply::route('/{record}'),
            'edit' => Pages\EditSupply::route('/{record}/edit'),
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
