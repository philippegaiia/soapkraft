<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FormulaItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('formula_items')->delete();
        
        \DB::table('formula_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'formula_id' => 1,
                'ingredient_id' => 6,
                'percentage_of_oils' => '44.00',
                'phase' => '10',
                'organic' => 1,
                'sort' => 1,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:36:08',
                'updated_at' => '2024-02-18 17:36:25',
            ),
            1 => 
            array (
                'id' => 2,
                'formula_id' => 1,
                'ingredient_id' => 4,
                'percentage_of_oils' => '19.00',
                'phase' => '10',
                'organic' => 1,
                'sort' => 2,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:36:09',
                'updated_at' => '2024-02-18 17:36:25',
            ),
            2 => 
            array (
                'id' => 3,
                'formula_id' => 1,
                'ingredient_id' => 8,
                'percentage_of_oils' => '7.00',
                'phase' => '10',
                'organic' => 1,
                'sort' => 3,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:36:09',
                'updated_at' => '2024-02-18 17:36:25',
            ),
            3 => 
            array (
                'id' => 4,
                'formula_id' => 1,
                'ingredient_id' => 9,
                'percentage_of_oils' => '30.00',
                'phase' => '10',
                'organic' => 1,
                'sort' => 4,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:36:09',
                'updated_at' => '2024-02-18 17:36:25',
            ),
            4 => 
            array (
                'id' => 5,
                'formula_id' => 1,
                'ingredient_id' => 50,
                'percentage_of_oils' => '24.00',
                'phase' => '20',
                'organic' => 0,
                'sort' => 5,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:36:09',
                'updated_at' => '2024-02-18 17:36:25',
            ),
            5 => 
            array (
                'id' => 6,
                'formula_id' => 1,
                'ingredient_id' => 38,
                'percentage_of_oils' => '10.00',
                'phase' => '20',
                'organic' => 0,
                'sort' => 6,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:36:09',
                'updated_at' => '2024-02-18 17:36:25',
            ),
            6 => 
            array (
                'id' => 7,
                'formula_id' => 2,
                'ingredient_id' => 6,
                'percentage_of_oils' => '41.00',
                'phase' => '10',
                'organic' => 1,
                'sort' => 1,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:41:08',
                'updated_at' => '2024-02-18 17:41:33',
            ),
            7 => 
            array (
                'id' => 8,
                'formula_id' => 2,
                'ingredient_id' => 9,
                'percentage_of_oils' => '30.00',
                'phase' => '10',
                'organic' => 1,
                'sort' => 2,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:41:08',
                'updated_at' => '2024-02-18 17:41:33',
            ),
            8 => 
            array (
                'id' => 9,
                'formula_id' => 2,
                'ingredient_id' => 4,
                'percentage_of_oils' => '23.00',
                'phase' => '10',
                'organic' => 1,
                'sort' => 3,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:41:08',
                'updated_at' => '2024-02-18 17:41:33',
            ),
            9 => 
            array (
                'id' => 10,
                'formula_id' => 2,
                'ingredient_id' => 8,
                'percentage_of_oils' => '6.00',
                'phase' => '10',
                'organic' => 1,
                'sort' => 4,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:41:08',
                'updated_at' => '2024-02-18 17:41:33',
            ),
            10 => 
            array (
                'id' => 11,
                'formula_id' => 2,
                'ingredient_id' => 50,
                'percentage_of_oils' => '24.00',
                'phase' => '20',
                'organic' => 0,
                'sort' => 5,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:41:08',
                'updated_at' => '2024-02-18 17:41:33',
            ),
            11 => 
            array (
                'id' => 12,
                'formula_id' => 2,
                'ingredient_id' => 38,
                'percentage_of_oils' => '9.65',
                'phase' => '20',
                'organic' => 0,
                'sort' => 6,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:41:08',
                'updated_at' => '2024-02-18 17:41:33',
            ),
            12 => 
            array (
                'id' => 13,
                'formula_id' => 2,
                'ingredient_id' => 21,
                'percentage_of_oils' => '1.60',
                'phase' => '30',
                'organic' => 1,
                'sort' => 7,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:41:08',
                'updated_at' => '2024-02-18 17:41:33',
            ),
            13 => 
            array (
                'id' => 14,
                'formula_id' => 2,
                'ingredient_id' => 52,
                'percentage_of_oils' => '1.00',
                'phase' => '30',
                'organic' => 1,
                'sort' => 8,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:41:08',
                'updated_at' => '2024-02-18 17:41:33',
            ),
            14 => 
            array (
                'id' => 15,
                'formula_id' => 2,
                'ingredient_id' => 19,
                'percentage_of_oils' => '1.00',
                'phase' => '30',
                'organic' => 1,
                'sort' => 9,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:41:08',
                'updated_at' => '2024-02-18 17:41:33',
            ),
            15 => 
            array (
                'id' => 16,
                'formula_id' => 2,
                'ingredient_id' => 45,
                'percentage_of_oils' => '0.10',
                'phase' => '30',
                'organic' => 0,
                'sort' => 10,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:41:08',
                'updated_at' => '2024-02-18 17:41:33',
            ),
            16 => 
            array (
                'id' => 17,
                'formula_id' => 2,
                'ingredient_id' => 53,
                'percentage_of_oils' => '0.30',
                'phase' => '30',
                'organic' => 0,
                'sort' => 11,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 17:41:08',
                'updated_at' => '2024-02-18 17:41:33',
            ),
        ));
        
        
    }
}