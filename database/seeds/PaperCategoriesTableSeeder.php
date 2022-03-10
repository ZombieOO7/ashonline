<?php

use Illuminate\Database\Seeder;

class PaperCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('paper_categories')->delete();
        
        \DB::table('paper_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => '705b110b-b473-45cb-9bfa-cab077b2e5cf',
                'title' => '6+',
                'slug' => 'six-plus',
                'content' => '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>',
                'image' => NULL,
                'extension' => NULL,
                'mime_type' => NULL,
                'image_path' => NULL,
                'thumb_path' => NULL,
                'color_code' => '#956464',
                'position' => NULL,
                'product_content' => NULL,
                'type' => 1,
                'status' => 0,
                'sequence' => NULL,
                'project_type' => 0,
                'created_at' => '2019-12-20 07:29:49',
                'updated_at' => '2019-12-20 10:23:04',
                'deleted_at' => '2019-12-20 10:23:04',
            ),
            1 => 
            array (
                'id' => 3,
                'uuid' => '565cc3b0-d95d-48d1-a8d1-4b50832e314c',
                'title' => '7+',
                'slug' => 'seven-plus',
                'content' => '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>',
                'image' => 'pexels.jpeg',
                'extension' => 'jpeg',
                'mime_type' => 'image/jpeg',
                'image_path' => 'storage/app/papercategory1/O3Qa1U0IQBDw1ZpFFHAAu1FyEmzRbgZe4qlHI4h7.jpeg',
                'thumb_path' => 'storage/app/papercategory1/thumb/O3Qa1U0IQBDw1ZpFFHAAu1FyEmzRbgZe4qlHI4h7.jpeg',
                'color_code' => '#ffe0b2',
                'position' => 6,
                'product_content' => NULL,
                'type' => 1,
                'status' => 1,
                'sequence' => 1,
                'project_type' => 0,
                'created_at' => '2019-12-17 10:15:31',
                'updated_at' => '2020-01-01 07:06:17',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 4,
                'uuid' => '5549a4cb-ea32-448e-bd6e-1e2c275a24c8',
                'title' => '10+',
                'slug' => 'ten-plus',
                'content' => '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>',
                'image' => NULL,
                'extension' => NULL,
                'mime_type' => NULL,
                'image_path' => NULL,
                'thumb_path' => NULL,
                'color_code' => '#b2ebf2',
                'position' => 3,
                'product_content' => NULL,
                'type' => 1,
                'status' => 1,
                'sequence' => 4,
                'project_type' => 0,
                'created_at' => '2019-12-19 10:21:46',
                'updated_at' => '2020-01-01 11:31:21',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 5,
                'uuid' => '270b4b67-faa6-4461-9ecb-0c8a049762c2',
                'title' => '9+',
                'slug' => 'nine-plus',
                'content' => '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>',
                'image' => NULL,
                'extension' => NULL,
                'mime_type' => NULL,
                'image_path' => NULL,
                'thumb_path' => NULL,
                'color_code' => '#dcedc8',
                'position' => 4,
                'product_content' => NULL,
                'type' => 1,
                'status' => 1,
                'sequence' => 3,
                'project_type' => 0,
                'created_at' => '2019-12-19 10:22:31',
                'updated_at' => '2019-12-20 08:36:42',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 6,
                'uuid' => '30b23381-675a-4798-8c77-3fb1068fde42',
                'title' => '11+ Grammar',
                'slug' => 'eleven-plus-grammar',
                'content' => '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>',
                'image' => NULL,
                'extension' => NULL,
                'mime_type' => NULL,
                'image_path' => NULL,
                'thumb_path' => NULL,
                'color_code' => '#c8e6c9',
                'position' => 2,
                'product_content' => NULL,
                'type' => 1,
                'status' => 1,
                'sequence' => 6,
                'project_type' => 0,
                'created_at' => '2019-12-19 10:20:11',
                'updated_at' => '2019-12-20 08:36:42',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 7,
                'uuid' => 'aac5442f-c6ae-4c2a-adf4-966a0e240bfe',
                'title' => '8+',
                'slug' => 'eight-plus',
                'content' => '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>',
                'image' => 'pexels.jpeg',
                'extension' => 'jpeg',
                'mime_type' => 'image/jpeg',
                'image_path' => 'storage/app/papercategory2/d3ZD8EGiWB2L26rUKtDK9sIHM47Ecxqk5OQd7rib.jpeg',
                'thumb_path' => 'storage/app/papercategory2/thumb/d3ZD8EGiWB2L26rUKtDK9sIHM47Ecxqk5OQd7rib.jpeg',
                'color_code' => '#fff9c4',
                'position' => 5,
                'product_content' => NULL,
                'type' => 1,
                'status' => 1,
                'sequence' => 2,
                'project_type' => 0,
                'created_at' => '2019-12-17 12:55:08',
                'updated_at' => '2019-12-20 08:36:42',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 8,
                'uuid' => 'd5fcf06f-bd4c-45d5-8e9b-3282aa1842b2',
                'title' => '11+ Independent',
                'slug' => 'eleven-plus-independent',
                'content' => '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>',
                'image' => NULL,
                'extension' => NULL,
                'mime_type' => NULL,
                'image_path' => NULL,
                'thumb_path' => NULL,
                'color_code' => '#ffccbc',
                'position' => 1,
                'product_content' => NULL,
                'type' => 1,
                'status' => 1,
                'sequence' => 5,
                'project_type' => 0,
                'created_at' => '2019-12-19 10:16:41',
                'updated_at' => '2019-12-20 08:36:42',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 9,
                'uuid' => '06b9a5a6-93bc-402a-aaff-5e2527c501e4',
                'title' => 'SATs',
                'slug' => 'sats',
                'content' => '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>',
                'image' => NULL,
                'extension' => NULL,
                'mime_type' => NULL,
                'image_path' => NULL,
                'thumb_path' => NULL,
                'color_code' => '#d1c4e9',
                'position' => 7,
                'product_content' => '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>',
                'type' => 2,
                'status' => 1,
                'sequence' => 7,
                'project_type' => 0,
                'created_at' => '2019-12-19 10:22:51',
                'updated_at' => '2019-12-30 11:42:16',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}