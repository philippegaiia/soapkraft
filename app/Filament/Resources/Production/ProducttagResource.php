<?php

namespace App\Filament\Resources\Production;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\Production\Producttag;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ColorPicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Production\ProducttagResource\Pages;
use App\Filament\Resources\Production\ProducttagResource\RelationManagers;

class ProducttagResource extends Resource
{
    protected static ?string $model = Producttag::class;
    protected static ?string $navigationGroup = 'Produits';

    protected static ?string $navigationLabel = 'Tags';

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            TextInput::make('name')->required()->maxlength(255),
            ColorPicker::make('color'),
            
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('name')
            ->searchable(),
            Tables\Columns\ColorColumn::make('color'),
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
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProducttags::route('/'),
            'create' => Pages\CreateProducttag::route('/create'),
            'edit' => Pages\EditProducttag::route('/{record}/edit'),
        ];
    }
}
