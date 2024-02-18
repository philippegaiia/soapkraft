<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Production\Producttag;
use phpDocumentor\Reflection\DocBlock\Tag;
use Database\Seeders\ProductCategorySeeder;
use Database\Seeders\SupplierListingSeeder;
use Database\Seeders\Supply\SupplierSeeder;
use Database\Seeders\Supply\IngredientSeeder;
use Database\Seeders\Supply\IngredientCategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // Seed users
        \App\Models\User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@admin.com',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test Utilisateur',
            'email' => 'user@user.com',
        ]);

        // seed suppliers
        $this->call(SupplierSeeder::class);

        // seed contacts

        DB::table('supplier_contacts')->insert([
            [
                'first_name' => 'Marie',
                'last_name' => 'Duarte',
                'supplier_id' => 1,
                'email' => 'marie@cauvin.com',
            ],
            [
                'first_name' => 'Cécile',
                'last_name' => 'Manzanere',
                'supplier_id' => 1,
                'email' => 'cecilie@cauvin.com',
            ],
            [
                'first_name' => 'Olivier',
                'last_name' => 'Himbert',
                'supplier_id' => 4,
                'email' => 'cecilie@cauvin.com',
            ],
        ]);

        DB::table('producttags')->insert([
            [
                'name' => 'neutre',
                'color' => '#000000',
                
            ],
            [
                'name' => 'neutre',
                'color' => '#fafafa',
            ],
            [
                'name' => 'neutre',
                'color' => '#e8e8e8',
            ],
        ]);

        $this->call(IngredientCategorySeeder::class);
        $this->call(IngredientSeeder::class);
        $this->call(SupplierListingSeeder::class);
        $this->call(ProductCategorySeeder::class);
        //$this->call(ProductSeeder::class);
        $this->call(ProductsTableSeeder::class);

        
        $this->call(SupplierOrdersTableSeeder::class);
        $this->call(SupplierOrderItemsTableSeeder::class);
        $this->call(SuppliesTableSeeder::class);
        
        
        $this->call(FormulasTableSeeder::class);
        $this->call(FormulaItemsTableSeeder::class);
        $this->call(ProductProducttagTableSeeder::class);
        $this->call(FormulaProductTableSeeder::class);
    }
}
 