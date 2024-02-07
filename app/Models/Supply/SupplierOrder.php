<?php

namespace App\Models\Supply;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class SupplierOrder extends Model
{
    use HasFactory; 

    Use SoftDeletes;

    /*protected $filllable = [
        'supplier_id','order_status','order_ref','order_date','delivery_date','confirmation_number','invoice_number','bl_number','freight_cost','description', 'series'
    ];*/

    protected $guarded = [
        
    ];

    protected $casts = [
        'order_status' => OrderStatus::class,
    ];

    public function supplier_order_items(): HasMany
    {
        return $this->hasMany(SupplierOrderItem::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function supplier_listings(): HasManyThrough
    {
        return $this->hasManyThrough(SupplierListing::class, SupplierOrderItem::class);
    }
}
