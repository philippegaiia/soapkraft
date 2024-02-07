<?php

namespace App\Filament\Resources\Supply;

use App\Enums\Packaging;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Supply\Supplier;
use Filament\Resources\Resource;
use App\Models\Supply\Ingredient;
use App\Models\Supply\SupplierListing;
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
                Forms\Components\TextInput::make('unit_weight')
                    ->numeric(),
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
            ->columns([

                Tables\Columns\TextColumn::make('name')
                    ->label('designation')
                    ->searchable(),

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

                Tables\Columns\TextColumn::make('pkg'),

                Tables\Columns\TextColumn::make('unit_weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\IconColumn::make('organic')
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
                Tables\Actions\EditAction::make(),
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
