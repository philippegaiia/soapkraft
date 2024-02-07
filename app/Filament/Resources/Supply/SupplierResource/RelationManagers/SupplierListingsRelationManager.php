<?php

namespace App\Filament\Resources\Supply\SupplierResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Enums\Packaging;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Supply\Ingredient;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class SupplierListingsRelationManager extends RelationManager
{
    protected static string $relationship = 'supplier_listings';


    public function form(Form $form): Form
    {
        return $form
            ->schema([Forms\Components\Select::make('ingredient_id')
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('unit_weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\IconColumn::make('organic')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])

            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),   
                ])            
            ])

            ->bulkActions([
               // Tables\Actions\BulkActionGroup::make([
               //     Tables\Actions\DeleteBulkAction::make(),
               // ]),
            ]);
    }
}
