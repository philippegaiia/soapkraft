<?php

namespace App\Filament\Resources\Supply\SupplierResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\Supply\SupplierContactResource\Pages\CreateSupplierContact;
use Filament\Forms\FormsComponent;

class ContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'contacts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('supplier_id')
                ->relationship('supplier', 'name')
            ->visible(fn ($livewire) => $livewire instanceof CreateSupplierContact)
                    ->required(),
                Forms\Components\TextInput::make('first_name')
                ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('mobile')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('department')
                ->maxLength(255),
                
            ]);
            
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('first_name')
            ->columns([
            Tables\Columns\TextColumn::make('supplier.name')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('first_name')
                ->searchable(),
            Tables\Columns\TextColumn::make('last_name')
                ->searchable(),
            Tables\Columns\TextColumn::make('phone')
                ->searchable(),
            Tables\Columns\TextColumn::make('mobile')
                ->searchable(),
            Tables\Columns\TextColumn::make('email')
                ->searchable(),
            Tables\Columns\TextColumn::make('department')
                ->searchable(),
            ])
            ->filters([
                // 
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
