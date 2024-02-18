<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierOrdersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('supplier_orders')->delete();

        DB::table('supplier_orders')->insert(array (
            0 => 
            array (
                'id' => 1,
                'supplier_id' => 16,
                'serial_number' => 1,
                'order_status' => 5,
                'order_ref' => '2024-ACB-0001',
                'order_date' => '2024-02-12',
                'delivery_date' => '2024-02-18',
                'confirmation_number' => NULL,
                'invoice_number' => 'efzefze',
                'bl_number' => 'zefzefz',
                'freight_cost' => NULL,
                'description' => NULL,
                'deleted_at' => '2024-02-18 16:19:05',
                'created_at' => '2024-02-18 16:18:34',
                'updated_at' => '2024-02-18 16:19:05',
            ),
            1 => 
            array (
                'id' => 2,
                'supplier_id' => 19,
                'serial_number' => 2,
                'order_status' => 5,
                'order_ref' => '2024-RDA-0002',
                'order_date' => '2024-02-11',
                'delivery_date' => '2024-02-18',
                'confirmation_number' => NULL,
                'invoice_number' => 'dfsfsfs',
                'bl_number' => 'sdfsdfsdfs',
                'freight_cost' => '34.00',
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:19:46',
                'updated_at' => '2024-02-18 16:19:46',
            ),
            2 => 
            array (
                'id' => 3,
                'supplier_id' => 4,
                'serial_number' => 3,
                'order_status' => 5,
                'order_ref' => '2024-AKE-0003',
                'order_date' => '2024-02-04',
                'delivery_date' => '2024-02-18',
                'confirmation_number' => NULL,
                'invoice_number' => 'sdfsdfsd',
                'bl_number' => 'sdfsdfs',
                'freight_cost' => NULL,
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:22:08',
                'updated_at' => '2024-02-18 16:22:08',
            ),
            3 => 
            array (
                'id' => 4,
                'supplier_id' => 2,
                'serial_number' => 4,
                'order_status' => 5,
                'order_ref' => '2024-OLI-0004',
                'order_date' => '2024-02-17',
                'delivery_date' => '2024-02-18',
                'confirmation_number' => 'dfgh',
                'invoice_number' => 'gfhdfhg',
                'bl_number' => 'dfghdfgh',
                'freight_cost' => NULL,
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:26:09',
                'updated_at' => '2024-02-18 16:31:32',
            ),
            4 => 
            array (
                'id' => 5,
                'supplier_id' => 13,
                'serial_number' => 5,
                'order_status' => 5,
                'order_ref' => '2024-MDO-0005',
                'order_date' => '2024-02-04',
                'delivery_date' => '2024-02-18',
                'confirmation_number' => NULL,
                'invoice_number' => 'oihoiho',
                'bl_number' => NULL,
                'freight_cost' => NULL,
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-02-18 16:33:01',
                'updated_at' => '2024-02-18 16:33:01',
            ),
        ));
        
        
    }
}