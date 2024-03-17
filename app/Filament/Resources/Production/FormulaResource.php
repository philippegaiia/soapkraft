<?php

namespace App\Filament\Resources\Production;

use Filament\Forms;
use Filament\Tables;
use App\Enums\Phases;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\Supply\Ingredient;
use App\Models\Production\Formula;
use App\Models\Production\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Production\FormulaResource\Pages;

class FormulaResource extends Resource
{
    protected static ?string $model = Formula::class;

    protected static ?string $navigationGroup = 'Produits';

    protected static ?string $navigationLabel = 'Formules';


    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    public static function form(Form $form): Form
    {
        
        return $form
            ->schema([
                Section::make('Détails Formule')
                    ->schema([
                        TextInput::make('name')
                            ->unique(Formula::class, ignoreRecord: true)
                            ->maxLength(255),
                            
                        TextInput::make('code')
                            ->maxLength(20)
                            ->disabledOn('edit')
                            ->unique(Formula::class, ignoreRecord: true)
                            ->required(fn (string $operation): bool => $operation === 'create'),

                        Select::make('product_id')
                            ->relationship('product', 'name')
                            ->options(Product::all()->pluck('name', 'id'))
                            ->preload()
                            ->searchable()
                            ->required(),

                        TextInput::make('dip_number')
                            ->maxLength(50),

                        Toggle::make('is_active')
                            ->default(true),

                        Fieldset::make('Dates')
                            ->schema([
                                DatePicker::make('date_of_creation')
                                ->required()
                                    ->default(now())
                                    ->native(false)
                                    ->weekStartsOnMonday(),
                            
                            ])->columnSpanFull(),

                        Section::make('Informations sur la Formule')
                            ->schema([
                                MarkdownEditor::make('description')
                            ])
                            ->collapsed()
                            ->columnSpanFull()

                ])->columns(4),
                //  ]);
Section::make()
                ->hiddenOn('create')
                ->columns(1)
                ->maxWidth('1/2')
                ->schema([
                    Fieldset::make('Totaux')
                    ->schema([
                            Forms\Components\Placeholder::make('total_saponified')
                                ->content(function ($get)
                                {
                                    $total = 0;
                                    
                                    foreach ($get('formula_items') as $item) {
                                        if ($item['phase'] === Phases::Saponification->value){
                                            $total += (int)$item['percentage_of_oils'];
                                        }
                                        
                                    }
                                    return $total;
                                }),

                            Forms\Components\Placeholder::make('total_formula')
                                ->content(function ($get) {
                                    $total = 0;
                                    foreach ($get('formula_items') as $item) {
                                        //dd($total);
                                        $total += (int)$item['percentage_of_oils'];
                                         
                                    }
                                    if ($total !== 0) {
                                    $totalformula = 100 / $total;
                                    return $totalformula;
                                    }
                                })
                            ]),
                Section::make('Items Formule')
                    ->schema([
                        Forms\Components\Repeater::make('formula_items')
                        ->relationship()
                            ->hiddenOn('create')
                            ->schema([
                                Select::make('ingredient_id')
                            /* ->relationship(
                                    name: 'ingredient',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn (Builder $query, Get $get): Builder => $query->where('supplier_id', $get('../../supplier_id')),
                                    )*/
                                    ->label('Ingrédient')
                                    ->options(Ingredient::where('is_active', true)->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->native(false)
                                    ->columnSpan(6),

                                TextInput::make('percentage_of_oils')
                                    ->label('% d\'huiles')
                                    ->postfix('%')
                                    ->numeric()
                                    ->live()
                                    ->dehydrated()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        $set('percentage_of_total', 'percentage_of_oils');
                                    })                                 
                                    ->default(1)
                                    ->columnSpan(3),

                                Select::make('phase')
                                    ->label('Phase')
                                    ->options(Phases::class)
                                    ->default(Phases::Saponification)
                                    ->native(false)
                                    ->columnSpan(4),

                                Toggle::make('organic')
                                    ->label('Bio')
                                    //->default(true)
                                    ->inline(false)
                                    ->columnSpan(3),

                                Placeholder::make('percentage_of_total')
                                    ->label('Total')
                        //->dehydrated()
                                    ->content(function (Get $get): string {
                                        return number_format($get('percentage_of_oils') , 2);
                                        })
                                    ->live(),

                        ])->columns(18)
                        ->defaultItems(1)
                        ->reorderableWithButtons()
                        ->orderColumn('sort')
                        ->live()                  
                                ]),
            
                    
                        
                        // Read-only, because it's calculated
                        //->readOnly()
                        //->suffix('%')
                        // This enables us to display the subtotal on the edit page load
                       // ->afterStateHydrated(function (Get $get, Set $set) {
                        //    self::updateTotals($get, $set);
                        //})


                  /*  Forms\Components\TextInput::make('Total Formule')
                        ->numeric()
                        // Read-only, because it's calculated
                        ->readOnly()
                        // This enables us to display the subtotal on the edit page load
                        ->afterStateHydrated(function (Get $get, Set $set) {
                            self::updateTotals($get, $set);
                        }), */                   
                    ]),
            ]);
    }

 /*   public static function updateTotals(Get $get, $livewire): void
    {
        // Retrieve the state path of the form. Most likely, it's `data` but could be something else.
        $statePath = $livewire->getFormStatePath();

        $ingredients = data_get($livewire, $statePath . '.forumula_items');
        if (collect($ingredients)->isEmpty()) {
            return;
        }
        $selectedIngredients = collect($ingredients)->filter(fn ($item) => !empty($item['product_id']) && !empty($item['quantity']));

        $prices = collect($ingredients)->pluck('price', 'product_id');

        $subtotal = $selectedIngredients->reduce(function ($subtotal, $ingredient) use ($prices) {
            return $subtotal + ($prices[$ingredient['product_id']] * $ingredient['quantity']);
        }, 0);

        data_set($livewire, $statePath . '.subtotal', number_format($subtotal, 2, '.', ''));
        data_set($livewire, $statePath . '.total', number_format($subtotal + ($subtotal * (data_get($livewire, $statePath . '.taxes') / 100)), 2, '.', ''));
    }*/

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('name')
                ->label('Nom')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('code')
                ->searchable(),

            Tables\Columns\ToggleColumn::make('is_active')
                ->label('Active')
                ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                ])
                
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
            'index' => Pages\ListFormulas::route('/'),
            'create' => Pages\CreateFormula::route('/create'),
            'view' => Pages\ViewFormula::route('/{record}'),
            'edit' => Pages\EditFormula::route('/{record}/edit'),
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
