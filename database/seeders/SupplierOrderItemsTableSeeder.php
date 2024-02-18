<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierOrderItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('supplier_order_items')->delete();
        
        DB::table('supplier_order_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'supplier_order_id' => 2,
                'supplier_listing_id' => 26,
                'unit_weight' => '1.000',
                'quantity' => '2.000',
                'unit_price' => '134.00',
                'batch_number' => 'RDV0012',
                'expiry_date' => '2026-02-01',
                'is_in_supplies' => 'Stock',
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:21:27',
                'updated_at' => '2024-02-18 16:21:30',
            ),
            1 => 
            array (
                'id' => 2,
                'supplier_order_id' => 2,
                'supplier_listing_id' => 57,
                'unit_weight' => '1.000',
                'quantity' => '3.000',
                'unit_price' => '134.00',
                'batch_number' => 'RDV012',
                'expiry_date' => '2025-02-22',
                'is_in_supplies' => 'Stock',
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:21:27',
                'updated_at' => '2024-02-18 16:21:38',
            ),
            2 => 
            array (
                'id' => 3,
                'supplier_order_id' => 3,
                'supplier_listing_id' => 70,
                'unit_weight' => '25.000',
                'quantity' => '10.000',
                'unit_price' => '5.00',
                'batch_number' => 'ake02343',
                'expiry_date' => '2026-02-14',
                'is_in_supplies' => 'Stock',
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:23:08',
                'updated_at' => '2024-02-18 16:24:47',
            ),
            3 => 
            array (
                'id' => 4,
                'supplier_order_id' => 3,
                'supplier_listing_id' => 65,
                'unit_weight' => '25.000',
                'quantity' => '11.000',
                'unit_price' => '4.00',
                'batch_number' => 'ake0980',
                'expiry_date' => '2025-02-15',
                'is_in_supplies' => 'Stock',
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:23:08',
                'updated_at' => '2024-02-18 16:24:51',
            ),
            4 => 
            array (
                'id' => 5,
                'supplier_order_id' => 3,
                'supplier_listing_id' => 69,
                'unit_weight' => '18.400',
                'quantity' => '11.000',
                'unit_price' => '2.00',
                'batch_number' => 'ake0986',
                'expiry_date' => '2025-02-22',
                'is_in_supplies' => 'Stock',
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:24:34',
                'updated_at' => '2024-02-18 16:24:54',
            ),
            5 => 
            array (
                'id' => 6,
                'supplier_order_id' => 3,
                'supplier_listing_id' => 35,
                'unit_weight' => '1.000',
                'quantity' => '1.000',
                'unit_price' => '233.00',
                'batch_number' => 'ake9876',
                'expiry_date' => '2025-02-15',
                'is_in_supplies' => 'Stock',
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:24:34',
                'updated_at' => '2024-02-18 16:24:57',
            ),
            6 => 
            array (
                'id' => 7,
                'supplier_order_id' => 3,
                'supplier_listing_id' => 32,
                'unit_weight' => '1.000',
                'quantity' => '2.000',
                'unit_price' => '287.00',
                'batch_number' => 'ake098709',
                'expiry_date' => '2025-02-22',
                'is_in_supplies' => 'Stock',
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:24:34',
                'updated_at' => '2024-02-18 16:25:01',
            ),
            7 => 
            array (
                'id' => 8,
                'supplier_order_id' => 4,
                'supplier_listing_id' => 18,
                'unit_weight' => '27.000',
                'quantity' => '1.000',
                'unit_price' => '5.00',
                'batch_number' => 'oli9876',
                'expiry_date' => '2026-02-14',
                'is_in_supplies' => 'Stock',
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:31:01',
                'updated_at' => '2024-02-18 16:31:40',
            ),
            8 => 
            array (
                'id' => 9,
                'supplier_order_id' => 4,
                'supplier_listing_id' => 14,
                'unit_weight' => '25.000',
                'quantity' => '8.000',
                'unit_price' => '4.00',
                'batch_number' => 'OLI87687',
                'expiry_date' => '2025-02-15',
                'is_in_supplies' => 'Stock',
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:31:01',
                'updated_at' => '2024-02-18 16:31:43',
            ),
            9 => 
            array (
                'id' => 10,
                'supplier_order_id' => 4,
                'supplier_listing_id' => 17,
                'unit_weight' => '180.000',
                'quantity' => '2.000',
                'unit_price' => '2.23',
                'batch_number' => 'oli8753',
                'expiry_date' => '2025-02-08',
                'is_in_supplies' => 'Stock',
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:31:01',
                'updated_at' => '2024-02-18 16:31:47',
            ),
            10 => 
            array (
                'id' => 11,
                'supplier_order_id' => 4,
                'supplier_listing_id' => 12,
                'unit_weight' => '180.000',
                'quantity' => '2.000',
                'unit_price' => '4.56',
                'batch_number' => 'oli87',
                'expiry_date' => '2025-02-08',
                'is_in_supplies' => 'Stock',
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:31:01',
                'updated_at' => '2024-02-18 16:31:52',
            ),
            11 => 
            array (
                'id' => 12,
                'supplier_order_id' => 5,
                'supplier_listing_id' => 77,
                'unit_weight' => '25.000',
                'quantity' => '4.000',
                'unit_price' => '5.00',
                'batch_number' => 'kuyfgukygful',
                'expiry_date' => '2027-02-13',
                'is_in_supplies' => 'Stock',
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:33:21',
                'updated_at' => '2024-02-18 16:33:26',
            ),
        ));
        
        
    }
}