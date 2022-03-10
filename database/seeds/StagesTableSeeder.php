<?php

use Illuminate\Database\Seeder;

class StagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('stages')->delete();
        
        \DB::table('stages')->insert(array (
            0 => 
            array (
                'id' => 3,
                'uuid' => 'e294640f-7d7a-4fc8-bdf7-abee9c4d57b0',
                'title' => 'Key Stage 3',
                'deleted_at' => '2019-12-31 11:07:07',
                'created_at' => '2019-12-30 11:47:02',
                'updated_at' => '2019-12-31 11:07:07',
                'status' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'uuid' => '1aaf5f04-8250-4a83-b905-4b97cf1ca57c',
                'title' => 'Key Stage 2',
                'deleted_at' => NULL,
                'created_at' => '2019-12-30 11:46:51',
                'updated_at' => '2020-01-01 12:06:16',
                'status' => 1,
            ),
            2 => 
            array (
                'id' => 5,
                'uuid' => 'f4168997-c607-4a11-b030-f5bd2668a2b3',
                'title' => 'Key Stage 5',
                'deleted_at' => NULL,
                'created_at' => '2020-01-02 11:30:20',
                'updated_at' => '2020-01-02 11:30:20',
                'status' => 0,
            ),
            3 => 
            array (
                'id' => 4,
                'uuid' => 'cb3825c6-40b1-4e0f-8f94-d4e7b6df9852',
                'title' => 'Key Stage 4',
                'deleted_at' => NULL,
                'created_at' => '2020-01-01 12:06:29',
                'updated_at' => '2020-01-02 12:24:21',
                'status' => 0,
            ),
            4 => 
            array (
                'id' => 6,
                'uuid' => '13e59bae-aee3-43ad-a52f-cfa9e94fa451',
                'title' => 'Quia qui consequat',
                'deleted_at' => NULL,
                'created_at' => '2020-01-03 05:56:24',
                'updated_at' => '2020-01-03 05:56:24',
                'status' => 0,
            ),
            5 => 
            array (
                'id' => 7,
                'uuid' => '954c7a98-eb18-419b-92d0-a2e3a6856815',
                'title' => 'key stage 5',
                'deleted_at' => NULL,
                'created_at' => '2020-01-03 06:19:20',
                'updated_at' => '2020-01-03 06:19:30',
                'status' => 0,
            ),
            6 => 
            array (
                'id' => 8,
                'uuid' => '3bff4e27-fc4e-43c8-809f-e19b9989b3ec',
                'title' => 'Enim ad qui consecte',
                'deleted_at' => '2020-01-06 09:11:38',
                'created_at' => '2020-01-06 09:10:53',
                'updated_at' => '2020-01-06 09:11:38',
                'status' => 1,
            ),
            7 => 
            array (
                'id' => 9,
                'uuid' => '94c9b1f9-bc49-4023-8b57-829e2840ab4b',
                'title' => 'Incididunt id dolore',
                'deleted_at' => '2020-01-06 09:15:23',
                'created_at' => '2020-01-06 09:15:15',
                'updated_at' => '2020-01-06 09:15:23',
                'status' => 0,
            ),
            8 => 
            array (
                'id' => 1,
                'uuid' => '734e76c2-36ed-469a-8135-72b4a459f052',
                'title' => 'Key Stage 1',
                'deleted_at' => NULL,
                'created_at' => '2019-12-30 11:46:36',
                'updated_at' => '2020-01-06 13:15:52',
                'status' => 1,
            ),
        ));
        
        
    }
}