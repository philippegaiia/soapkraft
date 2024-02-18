<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuppliesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('supplies')->delete();
        
        DB::table('supplies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'supplier_listing_id' => 26,
                'order_ref' => '2024-RDA-0002',
                'batch_number' => 'RDV0012',
                'initial_quantity' => '2.000',
                'quantity_in' => NULL,
                'quantity_out' => NULL,
                'unit_price' => '134.00',
                'expiry_date' => '2026-02-01',
                'delivery_date' => '2024-02-18',
                'is_in_stock' => 1,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:21:30',
                'updated_at' => '2024-02-18 16:21:30',
            ),
            1 => 
            array (
                'id' => 2,
                'supplier_listing_id' => 57,
                'order_ref' => '2024-RDA-0002',
                'batch_number' => 'RDV012',
                'initial_quantity' => '3.000',
                'quantity_in' => NULL,
                'quantity_out' => NULL,
                'unit_price' => '134.00',
                'expiry_date' => '2025-02-22',
                'delivery_date' => '2024-02-18',
                'is_in_stock' => 1,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:21:38',
                'updated_at' => '2024-02-18 16:21:38',
            ),
            2 => 
            array (
                'id' => 3,
                'supplier_listing_id' => 70,
                'order_ref' => '2024-AKE-0003',
                'batch_number' => 'ake02343',
                'initial_quantity' => '250.000',
                'quantity_in' => NULL,
                'quantity_out' => NULL,
                'unit_price' => '5.00',
                'expiry_date' => '2026-02-14',
                'delivery_date' => '2024-02-18',
                'is_in_stock' => 1,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:24:47',
                'updated_at' => '2024-02-18 16:24:47',
            ),
            3 => 
            array (
                'id' => 4,
                'supplier_listing_id' => 65,
                'order_ref' => '2024-AKE-0003',
                'batch_number' => 'ake0980',
                'initial_quantity' => '275.000',
                'quantity_in' => NULL,
                'quantity_out' => NULL,
                'unit_price' => '4.00',
                'expiry_date' => '2025-02-15',
                'delivery_date' => '2024-02-18',
                'is_in_stock' => 1,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:24:51',
                'updated_at' => '2024-02-18 16:24:51',
            ),
            4 => 
            array (
                'id' => 5,
                'supplier_listing_id' => 69,
                'order_ref' => '2024-AKE-0003',
                'batch_number' => 'ake0986',
                'initial_quantity' => '202.400',
                'quantity_in' => NULL,
                'quantity_out' => NULL,
                'unit_price' => '2.00',
                'expiry_date' => '2025-02-22',
                'delivery_date' => '2024-02-18',
                'is_in_stock' => 1,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:24:54',
                'updated_at' => '2024-02-18 16:24:54',
            ),
            5 => 
            array (
                'id' => 6,
                'supplier_listing_id' => 35,
                'order_ref' => '2024-AKE-0003',
                'batch_number' => 'ake9876',
                'initial_quantity' => '1.000',
                'quantity_in' => NULL,
                'quantity_out' => NULL,
                'unit_price' => '233.00',
                'expiry_date' => '2025-02-15',
                'delivery_date' => '2024-02-18',
                'is_in_stock' => 1,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:24:57',
                'updated_at' => '2024-02-18 16:24:57',
            ),
            6 => 
            array (
                'id' => 7,
                'supplier_listing_id' => 32,
                'order_ref' => '2024-AKE-0003',
                'batch_number' => 'ake098709',
                'initial_quantity' => '2.000',
                'quantity_in' => NULL,
                'quantity_out' => NULL,
                'unit_price' => '287.00',
                'expiry_date' => '2025-02-22',
                'delivery_date' => '2024-02-18',
                'is_in_stock' => 1,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:25:01',
                'updated_at' => '2024-02-18 16:25:01',
            ),
            7 => 
            array (
                'id' => 8,
                'supplier_listing_id' => 18,
                'order_ref' => '2024-OLI-0004',
                'batch_number' => 'oli9876',
                'initial_quantity' => '27.000',
                'quantity_in' => NULL,
                'quantity_out' => NULL,
                'unit_price' => '5.00',
                'expiry_date' => '2026-02-14',
                'delivery_date' => '2024-02-18',
                'is_in_stock' => 1,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:31:40',
                'updated_at' => '2024-02-18 16:31:40',
            ),
            8 => 
            array (
                'id' => 9,
                'supplier_listing_id' => 14,
                'order_ref' => '2024-OLI-0004',
                'batch_number' => 'OLI87687',
                'initial_quantity' => '200.000',
                'quantity_in' => NULL,
                'quantity_out' => NULL,
                'unit_price' => '4.00',
                'expiry_date' => '2025-02-15',
                'delivery_date' => '2024-02-18',
                'is_in_stock' => 1,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:31:43',
                'updated_at' => '2024-02-18 16:31:43',
            ),
            9 => 
            array (
                'id' => 10,
                'supplier_listing_id' => 17,
                'order_ref' => '2024-OLI-0004',
                'batch_number' => 'oli8753',
                'initial_quantity' => '360.000',
                'quantity_in' => NULL,
                'quantity_out' => NULL,
                'unit_price' => '2.23',
                'expiry_date' => '2025-02-08',
                'delivery_date' => '2024-02-18',
                'is_in_stock' => 1,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:31:47',
                'updated_at' => '2024-02-18 16:31:47',
            ),
            10 => 
            array (
                'id' => 11,
                'supplier_listing_id' => 12,
                'order_ref' => '2024-OLI-0004',
                'batch_number' => 'oli87',
                'initial_quantity' => '360.000',
                'quantity_in' => NULL,
                'quantity_out' => NULL,
                'unit_price' => '4.56',
                'expiry_date' => '2025-02-08',
                'delivery_date' => '2024-02-18',
                'is_in_stock' => 1,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:31:52',
                'updated_at' => '2024-02-18 16:31:52',
            ),
            11 => 
            array (
                'id' => 12,
                'supplier_listing_id' => 77,
                'order_ref' => '2024-MDO-0005',
                'batch_number' => 'kuyfgukygful',
                'initial_quantity' => '100.000',
                'quantity_in' => NULL,
                'quantity_out' => NULL,
                'unit_price' => '5.00',
                'expiry_date' => '2027-02-13',
                'delivery_date' => '2024-02-18',
                'is_in_stock' => 1,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:33:26',
                'updated_at' => '2024-02-18 16:33:26',
            ),
        ));
        
        
    }
}