<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admins')->delete();
        $role = Role::updateOrCreate(['name'=>'superadmin','guard_name'=>'admin']);
        /** Super admin */
        $superadmin = [
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'webclues.superadmn@gmail.com',
            'password' => 'Ash@1234',
            'status' => 1,
        ];
        $superadmin = App\Models\Admin::updateOrCreate(['email'=>'webclues.superadmn@gmail.com'],$superadmin);
        $role = $superadmin->assignRole('superadmin');
        
    }
}