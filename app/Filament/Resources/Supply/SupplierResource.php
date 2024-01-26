<?php

namespace App\Filament\Resources\Supply;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\Supply\Supplier;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\FormsComponent;
use Filament\Forms\Components\Group;
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
                            Forms\Components\TextInput::make('name')
                                ->label('Raison Sociale')
                                ->required()
                                ->maxLength(50)
                                ->live(onBlur: true)
                               
                                ->afterStateUpdated(function(string $operation, $state,  Forms\Set $set) {
                                   
                                    if ($operation !== 'create') {
                                        return;
                                    }
                                    

                                    $set('slug', Str::slug($state));
                                    })
                                ->unique(Supplier::class, 'name', ignoreRecord: true)
                                ->columnSpan(3),
                                
                            Forms\Components\TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                //->disabled()
                                ->dehydrated()
                                ->unique(Supplier::class,'slug', ignoreRecord: true)
                                ->maxLength(100)
                                ->columnSpan(3),

                            Forms\Components\TextInput::make('code')
                                ->required()
                                ->unique(Supplier::class, 'code', ignoreRecord: true)
                                ->maxLength(3)
                                 ->columnSpan(2),

                            Forms\Components\TextInput::make('Customer_code')
                                ->label('Code Client')
                                ->maxLength(100)
                                ->columnSpan(2),

                            Forms\Components\Toggle::make('is_active')
                                ->label('Actif')
                                ->inline(false)
                                ->columnSpan(2),

                            Forms\Components\TextInput::make('address1')
                                ->label('Adresse')
                                ->maxLength(100)
                                ->columnSpan(3),

                            Forms\Components\TextInput::make('address2')
                                ->label('Complément d\'adresse')
                                ->maxLength(100)
                                ->columnSpan(3),

                            Forms\Components\TextInput::make('zipcode')
                                ->label('Code Postal')
                                ->maxLength(10)
                                ->columnSpan(2),

                            Forms\Components\TextInput::make('country')
                                ->label('Pays')
                                ->maxLength(255)
                                ->columnSpan(4),

                            Forms\Components\TextInput::make('email')
                                ->email()
                                ->maxLength(100)
                                ->columnSpan(2),

                            Forms\Components\TextInput::make('phone')
                                ->tel()
                                ->label('Téléphone')
                                ->maxLength(15)
                                ->columnSpan(2),

                            Forms\Components\TextInput::make('Site Internet')
                                ->tel()
                                ->maxLength(15)
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Téléphone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('website')
                    ->searchable(),
                Tables\Columns\TextColumn::make('actif')
                    ->label('Actif')
                    ->searchable(),           
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
                    if ($record->contacts()->count() > 0) {
                        Notification::make()
                            ->danger()
                            ->title('Fournisseur est utilisé')
                            ->body('Ce fournisseurs a des contacts. Supprimez leq contacts avant d effacer ce forunisseur .')
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
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
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
                            ->label('Raison Sociale'),

                        TextEntry::make('code'),

                         TextEntry::make('customer_code'),

                        TextEntry::make('address1')
                            ->label('Adresse'),
                            
                        TextEntry::make('address1')
                            ->label('Adresse Complément')
                            ->columnSpan('full'),

                        TextEntry::make('zipcode')
                            ->label('Code Postal'),

                        TextEntry::make('country')
                            ->label('Pays'),

                        TextEntry::make('email'),

                        TextEntry::make('phone')
                        ->label('Téléphone'),

                        TextEntry::make('website')
                        ->label('Site Internet'),
                    ])->columns(3),
                
                    Section::make('Notes')
                        ->schema([
                            TextEntry::make('description')
                            ->label('')
                                ->markdown()
                                ->prose(),
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
