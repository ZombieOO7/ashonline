<?php

use App\Models\ResourceCategory;
use Illuminate\Database\Seeder;

class ResourceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            [
                'name' => 'Past papers',
                'content' => 'Past papers',
                'slug' => 'past-papers'
            ],
            [
                'name' => 'AshACE sample papers',
                'content' => 'AshACE sample papers',
                'slug' => 'sample-papers'
            ],
            [
                'name' => 'AshACE Guidance',
                'content' => 'AshACE Guidance',
                'slug' => 'guidance'
            ],
            [
                'name' => 'Blog',
                'content' => 'blog',
                'slug' => 'blog'
            ]
        ];
        foreach($arr as $item) {
            ResourceCategory::create($item);
        }
    }
}
