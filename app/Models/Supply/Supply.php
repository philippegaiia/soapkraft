<?php

namespace App\Models\Supply;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supply extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $guarded = [];

   public function supplier_listing(): BelongsTo
   {
    return $this->belongsTo(SupplierListing::class);
   }

}
