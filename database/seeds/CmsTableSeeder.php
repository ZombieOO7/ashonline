<?php

use Illuminate\Database\Seeder;

class CmsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms')->delete();
        
        \DB::table('cms')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => NULL,
                'title' => 'Contact Us',
                'page_slug' => 'contact-us',
                'api_page_slug' => NULL,
                'content' => '<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo</p>',
                'image' => NULL,
                'image_path' => NULL,
                'extension' => NULL,
                'mime_type' => NULL,
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'meta_robots' => NULL,
                'project_type' => 0,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NULL,
                'updated_at' => '2020-12-16 10:37:38',
                'deleted_at' => NULL,
                'short_description' => '',
                'type' => 1,
                'school_id' => NULL,
                'logo' => NULL,
                'exam_style' => NULL,
                'image_id' => NULL,
                'logo_image_id' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'uuid' => NULL,
                'title' => 'Terms & Conditions',
                'page_slug' => 'terms-conditions',
                'api_page_slug' => NULL,
                'content' => '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>',
                'image' => NULL,
                'image_path' => NULL,
                'extension' => NULL,
                'mime_type' => NULL,
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'meta_robots' => NULL,
                'project_type' => 0,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NULL,
                'updated_at' => '2020-01-03 10:52:36',
                'deleted_at' => NULL,
                'short_description' => NULL,
                'type' => 1,
                'school_id' => NULL,
                'logo' => NULL,
                'exam_style' => NULL,
                'image_id' => NULL,
                'logo_image_id' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'uuid' => 'd0588ab4-3db0-40aa-a805-433063a8e364',
                'title' => 'Payments And Security',
                'page_slug' => 'payments-and-security',
                'api_page_slug' => NULL,
                'content' => '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>',
                'image' => NULL,
                'image_path' => NULL,
                'extension' => NULL,
                'mime_type' => NULL,
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'meta_robots' => NULL,
                'project_type' => 0,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NULL,
                'updated_at' => '2020-01-03 11:30:58',
                'deleted_at' => NULL,
                'short_description' => NULL,
                'type' => 1,
                'school_id' => NULL,
                'logo' => NULL,
                'exam_style' => NULL,
                'image_id' => NULL,
                'logo_image_id' => NULL,
            ),
            3 => 
            array (
                'id' => 5,
                'uuid' => 'd0588ab4-3db0-40aa-a805-433063a8e367',
                'title' => 'Privacy Policy',
                'page_slug' => 'privacy-policy',
                'api_page_slug' => 'privacy-policy',
                'content' => '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&nbsp;</p>',
                'image' => NULL,
                'image_path' => NULL,
                'extension' => NULL,
                'mime_type' => NULL,
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'meta_robots' => NULL,
                'project_type' => 0,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'short_description' => NULL,
                'type' => 1,
                'school_id' => NULL,
                'logo' => NULL,
                'exam_style' => NULL,
                'image_id' => NULL,
                'logo_image_id' => NULL,
            ),
            4 => 
            array (
                'id' => 43,
                'uuid' => '6dc7a3d2-e1c7-460d-9ee7-7193a1ae5cdc',
                'title' => 'Testimonials',
                'page_slug' => 'testimonials',
                'api_page_slug' => NULL,
                'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
                'image' => '',
                'image_path' => '',
                'extension' => NULL,
                'mime_type' => NULL,
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => 'sd',
                'meta_robots' => NULL,
                'project_type' => 0,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2020-12-08 11:20:10',
                'updated_at' => '2020-12-30 07:26:31',
                'deleted_at' => NULL,
                'short_description' => '<p>sdf</p>',
                'type' => 2,
                'school_id' => NULL,
                'logo' => NULL,
                'exam_style' => '<p>sdf</p>',
                'image_id' => NULL,
                'logo_image_id' => NULL,
            ),
            5 => 
            array (
                'id' => 44,
                'uuid' => '20e76adb-a7a2-4a9e-b16b-3d84ea9244f0',
                'title' => 'Benefits',
                'page_slug' => 'benefits',
                'api_page_slug' => 'benefits',
                'content' => '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&nbsp;</p>',
                'image' => '',
                'image_path' => '',
                'extension' => NULL,
                'mime_type' => NULL,
                'meta_title' => NULL,
                'meta_keyword' => 'benefits',
                'meta_description' => 'benefits',
                'meta_robots' => NULL,
                'project_type' => 0,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2020-12-08 11:22:30',
                'updated_at' => '2020-12-29 06:27:25',
                'deleted_at' => NULL,
                'short_description' => '',
                'type' => 1,
                'school_id' => NULL,
                'logo' => '',
                'exam_style' => '',
                'image_id' => NULL,
                'logo_image_id' => NULL,
            ),
            6 => 
            array (
                'id' => 47,
                'uuid' => 'dda659ff-add2-4621-97c2-8f59b51b8d73',
                'title' => 'Exam Guidance',
                'page_slug' => 'exam-guidance',
                'api_page_slug' => NULL,
                'content' => '<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.</p>',
                'image' => '',
                'image_path' => NULL,
                'extension' => NULL,
                'mime_type' => NULL,
                'meta_title' => NULL,
                'meta_keyword' => '',
                'meta_description' => '',
                'meta_robots' => NULL,
                'project_type' => 0,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2020-12-15 13:40:38',
                'updated_at' => '2020-12-30 10:06:21',
                'deleted_at' => NULL,
                'short_description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
                'type' => 1,
                'school_id' => NULL,
                'logo' => NULL,
                'exam_style' => '',
                'image_id' => NULL,
                'logo_image_id' => NULL,
            ),
                    ));
        
        
    }
}