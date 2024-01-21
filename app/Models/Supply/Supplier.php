<?php

namespace App\Models\Supply;

use App\Models\Supply\SupplierContact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'slug',
        'address',
        'zipcode',
        'country',
        'email',
        'phone',
        'description'
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(SupplierContact::class, 'supplier_id');
    }
}
