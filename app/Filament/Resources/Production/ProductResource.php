<?php

namespace App\Filament\Resources\Production;

use App\Filament\Resources\Production\ProductResource\Pages;
use App\Filament\Resources\Production\ProductResource\RelationManagers;
use App\Models\Production\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_category_id')
                    ->relationship('product_category', 'name')
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('code')
                    ->maxLength(255),
                Forms\Components\Select::make('producttags')
                    ->relationship('producttags', 'name')
                    ->preload()
                    ->multiple(),
                Forms\Components\Select::make('formulas')
                    ->relationship('formulas', 'name')
                    ->preload()
                    ->multiple(),
                Forms\Components\TextInput::make('wp_code')
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('launch_date')
                    ->native(false)    
                    ->required(),
                Forms\Components\TextInput::make('net_weight')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('ean_code')
                    ->maxLength(255),
                Forms\Components\MarkdownEditor::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->onColor('success')
                    ->offColor('warning')
                    ->required()
                    ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product_category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('producttags.name')
                    ->badge(),
                   // ->color('producttags.color'),
                Tables\Columns\TextColumn::make('formulas.name')
                ->badge(),
                //->color('producttags.color'),"Color: {$record->color}"
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('wp_code')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),              
                Tables\Columns\TextColumn::make('launch_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('net_weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ean_code')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->sortable(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
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
