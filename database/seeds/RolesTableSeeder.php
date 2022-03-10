<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->delete();
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'name' => 'superadmin',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
        ));
    }
}