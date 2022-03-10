<?php

use Illuminate\Database\Seeder;

class PromoCodesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('promo_codes')->delete();
        
        \DB::table('promo_codes')->insert(array (
            0 => 
            array (
                'id' => 4,
                'uuid' => '38878b9e-2334-4458-a39c-2e44f1416013',
                'code' => 'EPPDISCOUNT2',
                'amount_1' => '50',
                'amount_2' => '100',
                'discount_1' => '5',
                'discount_2' => '10',
                'status' => 0,
                'created_at' => '2020-01-07 06:18:22',
                'updated_at' => '2020-01-08 05:01:19',
                'deleted_at' => NULL,
                'start_date' => '2020-01-07 08:57:43',
                'end_date' => '2020-01-07 08:57:43',
            ),
            1 => 
            array (
                'id' => 3,
                'uuid' => 'c2d72024-fb26-4afc-b4bc-d469ac3a40ce',
                'code' => 'EPPDISCOUNT1',
                'amount_1' => '15',
                'amount_2' => '20',
                'discount_1' => '65',
                'discount_2' => '67',
                'status' => 0,
                'created_at' => '2020-01-07 06:00:41',
                'updated_at' => '2020-01-08 05:01:19',
                'deleted_at' => NULL,
                'start_date' => '2020-01-07 08:57:43',
                'end_date' => '2020-05-07 08:57:43',
            ),
            2 => 
            array (
                'id' => 2,
                'uuid' => '512676dd-9fe6-4999-aba8-1463905d3c30',
                'code' => 'EPPDISCOUNT',
                'amount_1' => '60',
                'amount_2' => '200',
                'discount_1' => '10',
                'discount_2' => '20',
                'status' => 1,
                'created_at' => '2020-01-07 05:47:47',
                'updated_at' => '2020-01-08 05:01:19',
                'deleted_at' => NULL,
                'start_date' => '2020-01-01 00:00:00',
                'end_date' => '2020-02-08 00:00:00',
            ),
            3 => 
            array (
                'id' => 5,
                'uuid' => '4ebc9fce-e620-4591-9bcb-f190bc1aecd8',
                'code' => 'ABCEDFGH',
                'amount_1' => '5',
                'amount_2' => '7',
                'discount_1' => '6',
                'discount_2' => '7',
                'status' => 0,
                'created_at' => '2020-01-07 09:15:18',
                'updated_at' => '2020-01-07 10:29:05',
                'deleted_at' => '2020-01-07 10:29:05',
                'start_date' => '2020-01-16 00:00:00',
                'end_date' => '2020-01-31 00:00:00',
            ),
        ));
        
        
    }
}