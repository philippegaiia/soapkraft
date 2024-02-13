<?php

namespace App\Models\Supply;

use App\Enums\Packaging;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierListing extends Model
{
    use HasFactory; 
    use SoftDeletes;

        protected $fillable = [
        'id',
        'name',
        'code',
       'supplier_code',
        'pkg',
        'unit_weight',
        'price',
        'organic',
        'fairtrade',
        'cosmos',
        'ecocert',
        'description',  
        'is_active',
        'supplier_id',
        'ingredient_id'
    ];

    protected $casts = [
        'pkg' => Packaging::class,
    ];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

}
