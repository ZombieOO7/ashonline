<?php

use Illuminate\Database\Seeder;

class ResourceCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('resource_categories')->delete();
        
        \DB::table('resource_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => 'f62557cc-a5a8-43c8-9b9e-e799aa470d47',
                'name' => 'Past papers',
                'slug' => 'past-papers',
                'content' => 'Past papers',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-11-12 07:18:45',
                'updated_at' => '2020-11-12 07:18:45',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'uuid' => '5bef45e1-4784-4b29-a6ae-ccac07a58fec',
                'name' => 'AshACE sample papers',
                'slug' => 'sample-papers',
                'content' => 'AshACE sample papers',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-11-12 07:18:46',
                'updated_at' => '2020-11-12 07:18:46',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'uuid' => '006799f3-6cff-4d79-a610-9b34ae6ac856',
                'name' => 'AshACE Guidance',
                'slug' => 'guidance',
                'content' => 'AshACE Guidance',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-11-12 07:18:46',
                'updated_at' => '2020-11-12 07:18:46',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'uuid' => '66bd78c1-7617-487b-abbd-25d33a3c1fbe',
                'name' => 'Blog',
                'slug' => 'blog',
                'content' => 'blog',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-11-12 07:18:46',
                'updated_at' => '2020-11-12 07:18:46',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'uuid' => '66bd78c1-7617-487b-abbd-25d33a3c1fbf',
                'name' => 'Blog',
                'slug' => 'emock-blog',
                'content' => 'blog',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-11-12 07:18:46',
                'updated_at' => '2020-11-12 07:18:46',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}