<?php

namespace App\Filament\Resources\Production;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\ProductionStatus;
use Filament\Resources\Resource;
use App\Models\Production\Product;
use App\Models\Production\Production;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Production\ProductionResource\Pages;
use App\Filament\Resources\Production\ProductionResource\RelationManagers;

class ProductionResource extends Resource
{
    protected static ?string $model = Production::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('formulas')
                    ->relationship('formulas', 'name')
                    ->required(),
                Forms\Components\Select::make('parent_id')
                    ->relationship('parent', 'id'),
                Forms\Components\Toggle::make('is_masterbatch')
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->maxLength(255),
                Forms\Components\TextInput::make('batch_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\ToggleButtons::make('status')
                    ->options(ProductionStatus::class)
                    ->inline()
                    ->required()
                    ->default(ProductionStatus::Planned),
                Forms\Components\DatePicker::make('production_date')
                    ->required()
                    ->native(false),
                Forms\Components\DatePicker::make('ready_date')
                    ->required()
                    ->native(false),
                Forms\Components\TextInput::make('quantity_ingredients')
                    ->numeric(),
                Forms\Components\TextInput::make('units_produced')
                    ->numeric(),
                Forms\Components\Toggle::make('organic')
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('formula_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('parent.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_masterbatch')
                    ->boolean(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('batch_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('production_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ready_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity_ingredients')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('units_produced')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('organic')
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListProductions::route('/'),
            'create' => Pages\CreateProduction::route('/create'),
            'view' => Pages\ViewProduction::route('/{record}'),
            'edit' => Pages\EditProduction::route('/{record}/edit'),
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
