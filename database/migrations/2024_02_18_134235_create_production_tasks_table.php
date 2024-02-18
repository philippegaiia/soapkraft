<?php

use App\Models\Production\TaskType;
use App\Models\Production\Production;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Production\ProductionTaskType;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('production_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Production::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ProductionTaskType::class)->constrained()->cascadeOnDelete();
            $table->string('slug')->nullable();
            $table->date('date')->default(now());  
            $table->mediumText('notes')->nullable(); 
            $table->boolean('is_finished')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_tasks');
    }
};
