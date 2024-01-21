<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        DB::table('suppliers')->insert([
            //Global Admin
            [
                'name' => 'Cauvin',
                'code' => 'CAU',
            ],
            [
                'name' => 'Rosier Davennes',
                'code' => 'RDA',
                
            ],
            [
                'name' => 'Actibio',
                'code' => 'ACT',

            ],
            [
                'name' => 'Olisud',
                'code' => 'OLI',

            ],
        ]);

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


        
    }
}
 