<?php

namespace App\Filament\Resources\Supply;


use Filament\Forms;
use Illuminate\Validation\Rule;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Enums\OrderStatus;
use Filament\Tables\Table;
use App\Models\Supply\Supply;
use App\Models\Supply\Supplier;
use Filament\Resources\Resource;
use App\Models\Supply\SupplierOrder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use App\Models\Supply\SupplierListing;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use App\Models\Supply\SupplierOrderItem;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Supply\SupplierOrderResource\Pages;
use App\Filament\Resources\Supply\SupplierOrderResource\RelationManagers;

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
                                ->disabledOn('edit')    
                                -> afterStateUpdated(function (Get $get, Set $set, ?string $state, $record)
                                {
                                    $prefix = now()->year;  
                                    $supplierCode = Supplier::findOrFail($state)->code;
                                    $serie = $get('serial_number');
                                                                       
                                    $set('order_ref', $prefix.'-'.$supplierCode.'-'.$serie);
                                })
                                ->native(false)
                                ->required()
                                ->columnSpan(2),

                            TextInput::make('serial_number')
                                //->hidden()
                                ->disabledOn('edit')
                                ->numeric()
                                ->default(function () {
                                    $serie = (SupplierOrder::all()->max('serial_number') ?? 0 )+ 1;
                                    $serie = str_pad($serie, 4, '0', STR_PAD_LEFT);
                                    return $serie;
                                })
                                ->dehydrated()
                                ->unique(SupplierOrder::class, ignoreRecord: true)
                                ->required(fn (string $operation): bool => $operation === 'create')
                                ,
                                TextInput::make('order_ref')
                                ->maxLength(255)
                                ->disabled()
                                ->dehydrated(),
                            
                            
                                ToggleButtons::make('order_status')
                                ->options(OrderStatus::class)
                                ->inline()
                                ->default('draft')
                                ->columnSpan(4),


                            Fieldset::make('Dates')
                                ->schema([
                                    DatePicker::make('order_date')
                                    ->required()
                                    ->default(now()),
                                    DatePicker::make('delivery_date'),
                                ])->columnSpanFull(),                       
                            
                            Fieldset::make('Documents')
                                ->schema([
                                    TextInput::make('confirmation_number')
                                        ->maxLength(255)
                                        ->columnSpan(1),
                                    TextInput::make('invoice_number')
                                        ->maxLength(255)
                                        ->columnSpan(1),
                                    TextInput::make('bl_number')
                                        ->maxLength(255)
                                        ->columnSpan(1),
                                ])->columns(3),
                                                  
                            TextInput::make('freight_cost')
                                ->numeric(),

                            Section::make('Informations sur la Commande')
                            ->description('The items you have selected for purchase')
                                ->schema([
                                    MarkdownEditor::make('description')                               
                                ])
                                ->collapsed()
                                ->columnSpanFull()
                           
                        ])->columns(4),
                        
                    Forms\Components\Wizard\Step::make('Items')
                        ->schema([
                            Forms\Components\Repeater::make('supplier_order_items')
                                ->relationship()
                                ->schema([
                                    Select::make('supplier_listing_id')
                                        ->relationship(
                                            name: 'supplier_listing', 
                                            titleAttribute: 'name',
                                            modifyQueryUsing: fn (Builder $query, Get $get): Builder => $query->where('supplier_id', $get('../../supplier_id')),
                                        )
                                        ->live()
                                        ->afterStateUpdated(function ($state, Get $get, Set $set, ) {
                                                $supplier_listing = SupplierListing::find($state);
                                                $set('unit_weight', $supplier_listing->unit_weight);
                                            }) 
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
                                        ->default(1)
                                        ->columnSpan(1),

                                    TextInput::make('unit_weight')
                                        ->label('Poids')
                                        ->disabled()
                                        ->dehydrated()
                                        ->default(1)
                                        ->columnSpan(1),

                                    TextInput::make('unit_price')
                                        ->label('Prix')
                                       // ->dehydrated()
                                        ->numeric()
                                        ->columns(1),

                                    TextInput::make('batch_number')
                                        ->label('No. Lot')
                                        ->live()
                                        ->unique(SupplierOrderItem::class, ignoreRecord: true)
                                        ->columnSpan(1),

                                    DatePicker::make('expiry_date')
                                        ->label('DLUO')
                                        //->format('d/m/Y')
                                        ->native(false)
                                        ->closeOnDateSelection()
                                        ->columnSpan(1),

                                    Placeholder::make('total_quantity')
                                        ->label('Quantité')
                                        ->content(function ($get) {
                                            return $get('quantity') * $get('unit_weight');
                                        })->columnSpan(1),

                                    Checkbox::make('is_in_supplies')
                                        ->label('En Stock')
                                        //->isReadOnly()
                                        ->inline(false)
                                        ->columnSpan(1),

                                ])->columns(10)->defaultItems(0) 
                                    ->extraItemActions([
                                        Action::make('createNewInventory')
                                            ->icon('heroicon-m-envelope')
                                            ->action(function (array $arguments, Repeater $component, Set $set, $record, Supply $supply): void {
                                                $itemData = $component->getItemState($arguments['item']);
                                                 
                                             $supply->supplier_listing_id = $itemData['supplier_listing_id'];
                                             $supply->order_ref = $record->order_ref;
                                             $supply->save();

                                             Notification::make()
                                              ->title('Nouvelle entrée en stock')
                                              ->success()
                                              ->send();

                                            $set('../is_in_supplies', true);
                                            $state = $component->getState();
                                            dd($itemData['item']);


                                           /* Supply::create([
                                                'supplier_listing_id' => $itemData['supplier_listing_id'],
                                                'order_ref' => $record->order_ref,
                                            ]);*/
                                            })
                                        ])
                                    ]),
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
                    ->sortable()
                    ->searchable(),

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

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('list');
    }
}
