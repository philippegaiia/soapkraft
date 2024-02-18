<?php

namespace App\Filament\Resources\Supply;

use Filament\Forms;
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
use App\Models\Supply\SupplierListing;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Model;
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
                Section::make('Détails Commande')
                    ->schema([
                        Select::make('supplier_id')                         
                            ->relationship('supplier', 'name')
                            ->disabledOn('edit')    
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state, $record)
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
                                $serie = (SupplierOrder::withTrashed()->max('serial_number') ?? 0 )+ 1;
                                //dd($serie);
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
                            ->live()
                            ->default(OrderStatus::Draft)
                            ->columnSpan(4),

                        Fieldset::make('Dates')
                            ->schema([
                                DatePicker::make('order_date')
                                    ->required()
                                    ->default(now())
                                    ->native(false)
                                    ->weekStartsOnMonday(),
                                DatePicker::make('delivery_date')
                                    ->afterOrEqual('order_date')
                                    ->native(false)
                                    ->weekStartsOnMonday()
                            ])->columnSpanFull(),                       
                        
                        Fieldset::make('Documents')
                            ->schema([
                                TextInput::make('confirmation_number')
                                    ->maxLength(50)
                                    ->columnSpan(1),
                                TextInput::make('invoice_number')
                                    ->maxLength(50)
                                    ->columnSpan(1),
                                TextInput::make('bl_number')
                                    ->maxLength(50)
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
                            //  ]);

                Section::make('Items Commande')
                    ->schema([           
                    Forms\Components\Repeater::make('supplier_order_items')
                        ->relationship()
                        ->hiddenOn('create')
                        ->schema([
                            Select::make('supplier_listing_id')
                                ->relationship(
                                    name: 'supplier_listing', 
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn (Builder $query, Get $get): Builder => $query->where('supplier_id', $get('../../supplier_id')),
                                )
                                ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} {$record->unit_weight} {$record->unit_of_mesure}")
                                ->live()
                                ->afterStateUpdated(function ($state, Set $set, ) {
                                    $supplier_listing = SupplierListing::find($state);
                                    $set('unit_weight', $supplier_listing->unit_weight);
                                }) 
                                ->preload() 
                                ->required()
                                ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                ->native(false)
                                ->columnSpan(5)
                                ->searchable(),

                            TextInput::make('quantity')
                                ->numeric()
                                ->live()
                                ->dehydrated()
                                ->default(1)
                                ->columnSpan(2),

                            TextInput::make('unit_weight')
                                ->label('Poids')
                                ->disabled()
                                ->dehydrated()
                                ->default(1)
                                ->columnSpan(2),

                            TextInput::make('unit_price')
                                ->label('Prix')
                                // ->dehydrated()
                                ->numeric()
                                ->columnSpan(2),

                            TextInput::make('batch_number')
                                ->label('No. Lot')
                                //->live()
                                ->unique(SupplierOrderItem::class, ignoreRecord: true)
                                ->columnSpan(2),

                            DatePicker::make('expiry_date')
                                ->label('DLUO')
                                ->displayFormat('M Y')
                                ->native(false)
                                ->closeOnDateSelection()
                                ->columnSpan(2),

                            Placeholder::make('total_quantity')
                                ->label('Total')
                                ->content(function ($get) {
                                    return $get('quantity') * $get('unit_weight');
                                })->columnSpan(1),

                            TextInput::make('is_in_supplies')
                                ->label('Etat')
                                ->readonly()
                                ->dehydrated()
                                ->live()
                                ->default('Attente')
                                ->columnSpan(2),

                        ])->columns(18)
                            ->defaultItems(0)
                            ->deleteAction(
                                function (Action $action) {
                                    $action->label('Supprimer')
                                        ->icon('heroicon-m-trash')
                                        ->requiresConfirmation()
                                        ->hidden(fn(array $arguments, Repeater $component ) =>
                                            //!isset($component->getRawItemState($arguments['item'])['id']) 
                                           // || 
                                            $component->getRawItemState($arguments['item'])['is_in_supplies'] === 'Stock'
                                            )
                                        ->color('danger');
                                }
                            )
                            ->extraItemActions([
                                Action::make('createNewInventory')                                       
                                    ->label('Créer Stock')
                                    ->hidden(
                                        fn (array $arguments, Repeater $component, $record) =>
                                        !isset($component->getRawItemState($arguments['item'])['id'])
                                        || $component->getRawItemState($arguments['item'])['is_in_supplies'] === 'Stock' 
                                        || !isset($record->id) 
                                        || ($record->order_status !== OrderStatus::Checked)
                                    )
                                    ->icon('heroicon-m-arrow-trending-up')
                                    ->requiresConfirmation()
                                    
                                // ->after(function ($livewire) {
                                //      $livewire->dispatch('refreshIsInSupplies');
                                //  })
                                    ->action(function (array $arguments, Repeater $component, $record, $state): void {
                                        $itemData = $component->getItemState($arguments['item']);
                                        //dd($state);
                                        if (!isset($record->id) || !isset($component->getRawItemState($arguments['item'])['id'])){                   
                                            return;
                                        } 

                                        if ($itemData['quantity'] > 0 
                                        && isset($itemData['unit_price']) 
                                        && isset($itemData['batch_number'])
                                        && isset($record['delivery_date'])
                                        && isset($itemData['expiry_date']) 
                                        && ($record->order_status === OrderStatus::Checked) 
                                        && ($itemData['is_in_supplies'] === 'Attente'))
                                        {
                                            Supply::create([
                                                    'supplier_listing_id' => $itemData['supplier_listing_id'],
                                                    'order_ref' => $record->order_ref,
                                                    'batch_number' => $itemData['batch_number'],
                                                    'unit_price' => $itemData['unit_price'],
                                                    'initial_quantity' => $itemData['quantity'] * $itemData['unit_weight'] ,
                                                    'expiry_date' => $itemData['expiry_date'],
                                                    'delivery_date' => $record['delivery_date'],
                                                ]);

                                            Notification::make()
                                                ->title('Nouvelle création d\'inventaire')
                                                ->success()
                                                ->send();
                                            /**
                                            * Updates the is_in_supplies flag to true for the SupplierOrderItem with the given ID,
                                            * which indicates the item is now in stock. 
                                            * Saves the updated SupplierOrderItem record.
                                            * Sends a notification that the stock status was updated.
                                            */
                                            //$SupplyId = Str::after($arguments['item'], '-');
                                            $SupplyId = $component->getRawItemState($arguments['item'])['id'];
                                            $isInSupplies = SupplierOrderItem::findOrFail($SupplyId);
                                            $isInSupplies->is_in_supplies = 'Stock';
                                            $isInSupplies->save();

                                            Notification::make()
                                                ->title('Entrée en Stock mise à jour de' . $isInSupplies->supplier_listing->name)
                                                ->success()
                                                ->send();

                                            $unit_price = $itemData['unit_price'];
                                            $supplyId = $component->getRawItemState($arguments['item'])['supplier_listing_id'];
                                            $supplierListing = SupplierListing::findOrFail($supplyId);
                                            $supplierListing->price = $unit_price;
                                            $supplierListing->save();

                                            Notification::make()
                                            ->title('Prix mis à jour de' . $supplierListing->name)
                                            ->success()
                                            ->send();
                                            
                                        }
                                    })->successRedirectUrl(SupplierOrderResource::getUrl())
                                        //])                                    
                                ])->columnSpanFull()
                            ])
            ]);
                            
        }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier.name')
                    ->label('Fournisseur')
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
        return $this->getResource()::getUrl('edit');
    }

    protected $listeners = ['refreshIsInSupplies' => '$refresh'];
}
