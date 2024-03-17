<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormulasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('formulas')->delete();
        
        DB::table('formulas')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Savon Très Doux',
                'product_id' => 1,
                'slug' => NULL,
                'code' => 'GA001',
                'dip_number' => 'GA001',
                'is_active' => 1,
                'date_of_creation' => '2011-02-01',
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:34:33',
                'updated_at' => '2024-02-18 17:36:25',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Intuitif',
                'product_id' => 19,
                'slug' => NULL,
                'code' => 'GA011',
                'dip_number' => 'GA011',
                'is_active' => 1,
                'date_of_creation' => '2012-02-01',
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:38:24',
                'updated_at' => '2024-02-18 17:41:33',
            ),
        ));
        
        
    }
}