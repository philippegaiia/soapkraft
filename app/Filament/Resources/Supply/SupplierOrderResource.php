<?php

namespace App\Filament\Resources\Supply;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Enums\OrderStatus;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\Supply\SupplierOrder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use App\Models\Supply\SupplierListing;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use App\Models\Supply\SupplierOrderItem;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Supply\SupplierOrderResource\Pages;
use App\Filament\Resources\Supply\SupplierOrderResource\RelationManagers;
use App\Models\Supply\Supplier;

class SupplierOrderResource extends Resource
{
    protected static ?string $model = SupplierOrder::class;

    protected static ?string $navigationGroup = 'Achats';

    protected static ?string $navigationLabel = 'Commandes fournisseurs';

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Détail Commande')
                        ->schema([
                            Select::make('supplier_id')
                                ->relationship('supplier', 'name')
                                ->native(false)
                                ->required(),
                            TextInput::make('serial_number')
                                ->maxLength(255)
                                ->unique(SupplierOrder::class, ignoreRecord: true)
                                ->default(1),
                            Select::make('order_status')
                                ->options(OrderStatus::class)
                                ->native(false),
                            TextInput::make('order_ref')
                                ->maxLength(255),
                            DatePicker::make('order_date')
                                ->required()
                                ->default(now()),
                            DatePicker::make('delivery_date'),
                            TextInput::make('confirmation_number')
                                ->maxLength(255),
                            TextInput::make('invoice_number')
                                ->maxLength(255),
                            TextInput::make('bl_number')
                                ->maxLength(255),
                            TextInput::make('freight_cost')
                                ->numeric(),
                            MarkdownEditor::make('description')
                                ->columnSpanFull(),
                        ])->columns(2),
                        
                    Forms\Components\Wizard\Step::make('Items')
                        ->schema([
                            Forms\Components\Repeater::make('supplier_order_items')
                                ->relationship()
                                ->schema([
                                    Select::make('supplier_listing_id')
                                        ->relationship(
                                            name: 'supplier_listing', 
                                            titleAttribute: 'name',
                                            modifyQueryUsing: fn (Builder $query, $record, Get $get): Builder => $query->where('supplier_id', $get('../../supplier_id')),
                                        )
                                        // ->options()
                                        ->live()
                                       ->afterStateUpdated(function ($state, Get $get, Set $set, ) {
                                            $supplier_listing_id = $get('supplier_listing_id');
                                            $supplier_listing = SupplierListing::find($state);
                                            $set('unit_weight', $supplier_listing->unit_weight);
                                        }) 
                                       /*  ->afterStateUpdated(fn ($state, Set $set) => $set('unit_weight', SupplierListing::find($state)?->unit_weight ?? 0))*/
                                       ->preload() 
                                       ->required()
                                        ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                        ->native(false)
                                        ->columnSpan(3)
                                        ->searchable(),

                                    TextInput::make('quantity')
                                        ->numeric()
                                        ->live()
                                        ->dehydrated()
                                        ->default(1),

                                    TextInput::make('unit_weight')
                                        ->label('Poids Unitaire')
                                        ->disabled()
                                        ->dehydrated()
                                        ->default(1),
                                        //->numeric()
                                        //->required(),
                                    

                                    TextInput::make('unit_price')
                                        ->label('Prix Unitaire')
                                        ->dehydrated()
                                        // ->default(1)
                                        ->numeric(),
                                        //->required(),

                                    Placeholder::make('total_quantity')
                                        ->label('Quantité Totale')
                                        ->content(function ($get) {
                                            return $get('quantity') * $get('unit_weight');
                                        })
                                ])->columns(7)
                        ])

                    ])->columnSpanFull()
                
                    
                        ]);
            
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier.name')
                    ->label('Fournisseur')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('order_status')
                    ->label('Statut')
                    ->badge()
                    ->searchable(),

                Tables\Columns\TextColumn::make('order_ref')
                    ->label('Référence')
                    ->searchable(),

                Tables\Columns\TextColumn::make('order_date')
                    ->label('Date Commande')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('delivery_date')
                    ->label('Date Livraison')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('confirmation_number')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable(),

                Tables\Columns\TextColumn::make('bl_number')
                    ->searchable()
                     ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('freight_cost')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),

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
               // Tables\Filters\TrashedFilter::make(),
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
            'index' => Pages\ListSupplierOrders::route('/'),
            'create' => Pages\CreateSupplierOrder::route('/create'),
            'edit' => Pages\EditSupplierOrder::route('/{record}/edit'),
        ];
    }

    /**
     * Gets the Eloquent query builder for the model, without the soft deleting global scope.
     * This allows access to soft deleted models.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
