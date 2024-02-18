<?php

namespace App\Models\Supply;

use App\Models\Production\FormulaItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ingredient extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'ingredient_category_id',
        'code',
        'name',
        'name_en',
        'slug',
        'inci',
        'inci_naoh',
        'inci_koh',
        'cas',
        'cas_einecs',
        'einecs',
        'is_active',
        'description',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function ingredient_category(): BelongsTo
    {
        return $this->belongsTo(IngredientCategory::class, 'ingredient_category_id');
    }

    public function supplier_listings(): HasMany
    {
        return $this->hasMany(SupplierListing::class);
    }   

    /*public function formula_items(): HasMany
    {
        return $this->hasMany(FormulaItem::class);
    }*/
}
