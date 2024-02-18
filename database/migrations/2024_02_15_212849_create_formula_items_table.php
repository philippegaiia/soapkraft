<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('formula_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Production\Formula::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Supply\Ingredient::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->decimal('percentage_of_oils', 5, 2);
            $table->string('phase');
            $table->boolean('organic')->default(true);
            $table->integer('sort');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formula_items');
    }
};
