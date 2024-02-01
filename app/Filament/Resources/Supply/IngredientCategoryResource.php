<?php

namespace App\Filament\Resources\Supply;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use App\Models\Supply\Ingredient;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use App\Models\Supply\IngredientCategory;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Supply\IngredientCategoryResource\Pages;
use App\Filament\Resources\Supply\IngredientCategoryResource\RelationManagers;

class IngredientCategoryResource extends Resource
{
    protected static ?string $model = IngredientCategory::class;

    protected static ?string $navigationGroup = 'Achats';

    protected static ?string $navigationLabel = 'Catégories Ingrédients';

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 4;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('parent_id')
                ->relationship('parent', 'name', fn (Builder $query) => $query->where('parent_id', null))
                    ->native(false)
                    ->disabledOn('edit')
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state, $record){
                        if ($get('code') !== null) {
                            return;
                        }

                        $series = (IngredientCategory::all()->max('id') ?? 0) + 1;
                        $prefix = now()->year;
                        $set('code', $prefix . IngredientCategory::findOrFail($state)->code . '-' . $series + 100);
                    }),              
                    
                TextInput::make('name')
                    ->label('Nom')
                    ->required()
                    ->maxLength(50)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', str()->slug($state))), 

                TextInput::make('code')
                    ->required()
                    ->dehydrated()
                    ->unique(IngredientCategory::class, 'code', ignoreRecord: true)
                    ->maxLength(15),

                TextInput::make('slug')
                    ->disabledOn('edit')                   
                    ->dehydrated()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Toggle::make('is_visible')
                    ->required(),

                MarkdownEditor::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                TextColumn::make('name')
                    ->searchable()
                    ->label('Nom'),
                TextColumn::make('code')
                    ->searchable(),
                TextColumn::make('parent.name')
                    ->sortable()
                    ->label('Catégorie Parente'),
                TextColumn::make('slug')
                    ->searchable(),
                IconColumn::make('is_visible')
                    ->boolean()
                    ->label('Visible'),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
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
                    Tables\Actions\DeleteAction::make(),

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
            'index' => Pages\ListIngredientCategories::route('/'),
            'create' => Pages\CreateIngredientCategory::route('/create'),
            'edit' => Pages\EditIngredientCategory::route('/{record}/edit'),
        ];
    }
}
