<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Formula extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $guarded = [];

    public function formula_items(): HasMany
    {
        return $this->hasMany(FormulaItem::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withDefault();
    }

   /*  protected function total()
    {
        
                $total = 0;

                foreach ($this->quoteProducts as $product) {
                    $total += $product->price;
                }

                return $total;
            
        
    }

   protected function subtotal(): Attribute
    {
        return Attribute::make(
            get: function () {
                $subtotal = 0;

                foreach ($this->quoteProducts as $product) {
                    $subtotal += $product->price * $product->quantity;
                }

                return $subtotal;
            }
        );
    } */
}
