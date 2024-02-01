<?php

namespace App\Models\Supply;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierOrderItem extends Model
{
    use HasFactory;

    use SoftDeletes;

   /* protected $fillable = [
        'supplier_order_id, supplier_listing_id', 'quantity', 'unit_price', 'created_at', 'updated_at', 'deleted_at'
    ];*/
    protected $guarded = [

    ];

    public function supplier_order(): BelongsTo
    {
        return $this->belongsTo(SupplierOrder::class);
    }

  public function supplier_listing(): BelongsTo
    {
        return $this->belongsTo(SupplierListing::class);
    }
}
