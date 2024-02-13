<?php

namespace App\Models\Supply;

use App\Enums\IsInSuppliesStatus;
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

    protected $casts = [
     // 'is_in_supplies' => IsInSuppliesStatus::class,
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
