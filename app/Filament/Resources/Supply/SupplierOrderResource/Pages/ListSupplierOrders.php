<?php

namespace App\Filament\Resources\Supply\SupplierOrderResource\Pages;

use Filament\Actions;
use App\Enums\OrderStatus;
use App\Models\Supply\SupplierOrder;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Supply\SupplierOrderResource;

class ListSupplierOrders extends ListRecords
{
    protected static string $resource = SupplierOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
            ->badge(SupplierOrder::all()->count()),

            'draft' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('order_status', 'draft'))
                ->badge(SupplierOrder::query()->where('order_status', 'draft')->count()),

            'Passées' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('order_status', 'passée'))
                ->badge(SupplierOrder::query()->where('order_status', 'passée')->count()),

            'Confirmée' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('order_status', 'confirmée'))
                ->badge(SupplierOrder::query()->where('order_status', 'confirmée')->count()),

            'Livrées' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('order_status', 'livrée'))
                ->badge(SupplierOrder::query()->where('order_status', 'livrée')->count()),

        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'Confirmée';
    }
}
