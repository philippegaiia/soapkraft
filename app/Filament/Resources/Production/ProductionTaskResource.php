<?php

namespace App\Filament\Resources\Production;

use App\Filament\Resources\Production\ProductionTaskResource\Pages;
use App\Filament\Resources\Production\ProductionTaskResource\RelationManagers;
use App\Models\Production\ProductionTask;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductionTaskResource extends Resource
{
    protected static ?string $model = ProductionTask::class;

    protected static ?string $navigationGroup = 'Production';

    protected static ?string $navigationLabel = 'Tâches';


    protected static ?string $navigationIcon = 'heroicon-c-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('production_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('production_task_type_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('slug')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(16777215)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_finished')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('production_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('production_task_type_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_finished')
                    ->boolean(),
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
            'index' => Pages\ListProductionTasks::route('/'),
            'create' => Pages\CreateProductionTask::route('/create'),
            'view' => Pages\ViewProductionTask::route('/{record}'),
            'edit' => Pages\EditProductionTask::route('/{record}/edit'),
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
