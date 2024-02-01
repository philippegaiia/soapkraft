<?php


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use App\Models\Supply\IngredientCategory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ingredient_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->required();
            $table->string('code')->required()->unique();
            $table->string('slug')->unique();
            $table->foreignId('parent_id')
                    ->nullable()
                    ->constrained('ingredient_categories')
                    ->cascadeOnDelete();
            $table->boolean('is_visible')->default(true);
            $table->longText('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

           
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_categories');
    }
};
