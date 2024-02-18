<?php

namespace App\Models\Production;

use App\Enums\ProductionStatus;
use App\Models\Production\Product;
use Illuminate\Database\Eloquent\Model;
use App\Models\Production\ProductionItem;
use App\Models\Production\ProductionTask;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Production extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'organic' => 'boolean',
        'status'  => ProductionStatus::class
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Production::class, 'parent_id');
    }

    public function production_items(): HasMany
    {
        return $this->hasMany(ProductionItem::class);
    }

    public function production_tasks(): HasMany
    {
        return $this->hasMany(ProductionTask::class);   
    }
    
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
 