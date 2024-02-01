<?php

namespace App\Filament\Resources\Supply;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\Supply\Supplier;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\FormsComponent;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Split;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Filament\Resources\Supply\SupplierResource\Pages;
use App\Filament\Resources\Supply\SupplierResource\RelationManagers;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationGroup = 'Achats';

    protected static ?string $navigationLabel = 'Fournisseurs';

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
           // ->schema([
                // Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Détails Fournisseur')
                        ->schema([
                            TextInput::make('name')
                                ->label('Raison Sociale')
                                ->required()
                                ->maxLength(100)
                                ->live(onBlur: true)
                                ->afterStateHydrated(function (TextInput $component, ?string $state) {
                                    $component->state(ucwords($state));
                                })
                                ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state, ?string $operation,) {
                                    if ($get('slug') === null) {
                                        $set('slug', Str::slug($state));
                                        return;
                                    }                         
                                })                                  
                                ->unique(Supplier::class, 'name', ignoreRecord: true)
                                ->columnSpan(3),
                                
                            TextInput::make('slug')
                                //->disabledOn('edit')
                                ->label('Slug')
                                ->required()                              
                                ->dehydrated()
                                ->unique(ignoreRecord: true)
                                ->maxLength(100)
                                ->columnSpan(3),

                            TextInput::make('code')
                                ->required()
                                ->unique(Supplier::class, 'code', ignoreRecord: true)
                                ->maxLength(3)
                                 ->columnSpan(2),

                            TextInput::make('Customer_code')
                                ->label('Code Client')
                                ->maxLength(100)
                                ->columnSpan(2),

                            Forms\Components\Toggle::make('is_active')
                                ->label('Actif')
                                ->inline(false)
                                ->columnSpan(2),

                            TextInput::make('address1')
                                ->label('Adresse')
                                ->maxLength(100)
                                ->columnSpan(3),

                            TextInput::make('address2')
                                ->label('Complément d\'adresse')
                                ->maxLength(100)
                                ->columnSpan(3),

                            TextInput::make('zipcode')
                                ->label('Code Postal')
                                ->maxLength(10)
                                ->columnSpan(2),

                            TextInput::make('country')
                                ->label('Pays')
                                ->maxLength(255)
                                ->columnSpan(4),

                            TextInput::make('email')
                                ->email()
                                ->maxLength(100)
                                ->columnSpan(2),

                            TextInput::make('phone')
                                ->tel()
                                ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                ->label('Téléphone')
                                ->maxLength(15)
                                ->columnSpan(2),

                            TextInput::make('Site Internet')
                                ->url()
                                ->maxLength(100)
                                ->columnSpan(2),
                            ])->columns(6),
                            

                       // Forms\Components\Group::make()
                       //->schema([
                        Forms\Components\Section::make('Notes')
                            ->collapsed()
                            ->schema([
                            
                                Forms\Components\MarkdownEditor::make('description')
                                    ->columnSpanFull(),
                            ])->columns(6)
                          //  ])
                ]);
                            
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Raison Sociale')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('address1')
                    ->label('Adresse')  
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    

                Tables\Columns\TextColumn::make('address2')
                    ->label('Complément d\'adresse')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('zipcode')
                    ->label('Code Postal')
                    ->searchable(),

                Tables\Columns\TextColumn::make('country')
                    ->label('Pays')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Téléphone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('website')
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
           
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
                ActionGroup::make([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                ->action(function ($data, $record) {
                    if ($record->contacts()->count() > 0 || $record->supplier_listings()->count() > 0) {
                        Notification::make()
                            ->danger()
                            ->title('Opération Impossible')
                            ->body('Supprimez les fichiers liés à ce fournisseur pour le supprimer.')
                            ->send();

                        return;
                    }

                    Notification::make()
                        ->success()
                        ->title('Fournisseur Supprimé')
                        ->body('Le Fournisseur a été supprimé avec succès.')
                        ->send();

                    $record->delete();   
            
                
                }),
                ])
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                   // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SupplierListingsRelationManager::class, 
            RelationManagers\ContactsRelationManager::class,     
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            
               ->schema([
                              
                   Section::make('Détails Fournisseur')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Raison Sociale')
                            ->columnSpan(2),

                        TextEntry::make('code')
                            ->columnSpan(1),

                        TextEntry::make('customer_code')
                            ->columnSpan(1),

                        TextEntry::make('address1')
                            ->label('Adresse'),
                            
                        TextEntry::make('address2')
                            ->label('Adresse Complément'),                     

                        TextEntry::make('zipcode')
                            ->label('Code Postal'),

                        TextEntry::make('city')
                            ->label('VIlle'),

                        TextEntry::make('country')
                            ->label('Pays'),

                        TextEntry::make('email'),

                        TextEntry::make('phone')
                        ->label('Téléphone'),

                        TextEntry::make('website')
                        ->label('Site Internet'),

                    ])->columns(4),
                
                    Section::make('Notes')
                        ->collapsed()
                        ->schema([
                            TextEntry::make('description')
                                ->label('')
                                ->markdown()
                                ->prose()
                                
                        ]),
                    ]);                         
        
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'view' => Pages\ViewSupplier::route('/{record}'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}
