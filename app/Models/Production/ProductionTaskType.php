<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionTaskType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['id','name', 'slug', 'description'];

    public function productionTasks(): HasMany
    {
        return $this->hasMany(ProductionTask::class);
    }

}
