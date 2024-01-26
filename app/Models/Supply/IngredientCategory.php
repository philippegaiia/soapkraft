<?php

namespace App\Models\Supply;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IngredientCategory extends Model
{
    use HasFactory; 
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'code','slug', 'parent_id', 'is_visible', 'id'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(IngredientCategory::class, 'parent_id');
    }

    public function ingredients(): HasMany
    {
        return $this->hasMany(Ingredient::class);
    }
}
 