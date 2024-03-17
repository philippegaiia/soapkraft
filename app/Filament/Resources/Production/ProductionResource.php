<?php

namespace App\Filament\Resources\Production;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\ProductionStatus;
use Filament\Resources\Resource;
use App\Models\Production\Formula;
use App\Models\Production\Product;
use App\Models\Production\Production;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Production\ProductionResource\Pages;
use App\Filament\Resources\Production\ProductionResource\RelationManagers;

class ProductionResource extends Resource
{
    protected static ?string $model = Production::class;

    protected static ?string $navigationGroup = 'Production';

    protected static ?string $navigationLabel = 'Production';


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
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
                        $prodId = $get('product_id');
                    //    dd((int)$prodId);
                    //    $product = Product::find(1)->get(); 
                        $formula = Product::find((int)$prodId)->formulas()
                        //->where('is_active', true)
                        ->first();

                        if ($formula) {
                            $formulaId = $formula->id;
                            $set('formula_id', $formulaId);
                        }
                      //  $formula = Product::find(1)->formula;
                       // dd($formula);
                    })
                    ->required(),
                Forms\Components\Select::make('formula_id')
                    ->relationship('formula', 'name')
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                Forms\Components\Select::make('parent_id')
                    ->label('Masterbatch')
                    ->relationship('parent', 'id'),
                Forms\Components\ToggleButtons::make('is_masterbatch')
                    ->label('Masterbatch')
                    ->inline(false)
                    ->default(false)
                    ->boolean()
                    ->grouped()
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
                Forms\Components\Fieldset::make('Dates')
                    ->schema([
                        Forms\Components\DatePicker::make('production_date')
                            ->required()
                            ->default(now())
                            ->native(false)
                            ->weekStartsOnMonday(),
                        Forms\Components\DatePicker::make('ready_date')
                            ->afterOrEqual('production_date')
                            ->native(false)
                            ->weekStartsOnMonday()
                ])->columnSpanFull(),
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
