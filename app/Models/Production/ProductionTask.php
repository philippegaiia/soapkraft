<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionTask extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['id','production_task_type_id','name', 'slug', 'date', 'notes', 'is_finished'];

    public function production(): BelongsTo
    {
        return $this->belongsTo(Production::class);
    }

    public function productionTaskType(): BelongsTo
    {
        return $this->belongsTo(ProductionTaskType::class);
    }
}
