<?php

namespace App\Models\Production;

use App\Models\Production\Production;
use App\Models\Supply\SupplierListing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionItem extends Model
{
    use HasFactory;
    use SoftDeletes;    

    protected $guarded = [];

    protected $casts = [
        'organic' => 'boolean',
        'is_supplied' => 'boolean',
    ];

    public function production(): BelongsTo
    {
        return $this->belongsTo(Production::class);
    }

    public function production_task(): BelongsTo
    {
        return $this->belongsTo(SupplierListing::class);
    } 
}
