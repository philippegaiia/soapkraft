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

      /*  $categories = [
            [
                'id' => 1,
                'name' => 'Huiles et Beurres',
                'code' => 'OB',
               'slug' =>'huiles-et-beurres',
                'parent_id' => null,
                'is_visible' => false,
            ],

            [
                'id' => 2,
                'name' => 'Huiles essentielles',
                'code' => 'EO',
               'slug' =>'huiles-essentielles',
                'parent_id' => null,
                'is_visible' => true,
            ],

            [
                'id' => 3,
                'name' => 'Extraits Végétaux',
                'code' => 'BE',
               'slug' =>'extraits-végétaux',
                'parent_id' => null,
                'is_visible' => true,
            ],

            [
                'id' => 4,
                'name' => 'Huile d\'Olive',
                'code' => 'OB1',
               'slug' =>'huile-olive-vierge',
                'parent_id' => 1,
                'is_visible' => true,
            ],

            [
                'id' => 5,
                'name' => 'Beurre de Cacao',
                'code' => 'OB2',
                'slug' =>'huile-olive-raffinee',
                'parent_id' => 1,
                'is_visible' => true,
            ]
            
        ]; */


       /* $json = File::get('database/data/ingredient_categories.json');
        $ingredient_categories = json_decode($json, true);
        foreach ($ingredient_categories as $category) {
            IngredientCategory::create(array(
              'id' => $category->id,
                'name' => $category->name,
                'code' => $category->code,
                'slug' => $category->slug,
               'parent_id' => $category->parent_id,
                'is_visible' => $category->is_visible,
                'description' => $category->description,
                'deleted_at' => $category->deleted_at,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at
            ));  
        };*/




            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_categories');
    }
};
