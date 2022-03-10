<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCmsBlockColumnsToBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks', function (Blueprint $table) {
            if(!Schema::hasColumn('blocks','slider_1_title')){
                $table->text('slider_1_title')->nullable();
            }
            if(!Schema::hasColumn('blocks','slider_1_sub_title')){
                $table->text('slider_1_sub_title')->nullable();
            }
            if(!Schema::hasColumn('blocks','slider_1_description')){
                $table->text('slider_1_description')->nullable();
            }
            if(!Schema::hasColumn('blocks','slider_2_title')){
                $table->text('slider_2_title')->nullable();
            }
            if(!Schema::hasColumn('blocks','slider_2_sub_title')){
                $table->text('slider_2_sub_title')->nullable();
            }
            if(!Schema::hasColumn('blocks','slider_2_description')){
                $table->text('slider_2_description')->nullable();
            }
            if(!Schema::hasColumn('blocks','slider_3_title')){
                $table->text('slider_3_title')->nullable();
            }
            if(!Schema::hasColumn('blocks','slider_3_sub_title')){
                $table->text('slider_3_sub_title')->nullable();
            }
            if(!Schema::hasColumn('blocks','slider_3_description')){
                $table->text('slider_3_description')->nullable();
            }
            if(!Schema::hasColumn('blocks','title_1')){
                $table->text('title_1')->nullable();
            }
            if(!Schema::hasColumn('blocks','content_1')){
                $table->text('content_1')->nullable();
            }
            if(!Schema::hasColumn('blocks','title_2')){
                $table->text('title_2')->nullable();
            }
            if(!Schema::hasColumn('blocks','content_2')){
                $table->text('content_2')->nullable();
            }
            if(!Schema::hasColumn('blocks','title_3')){
                $table->text('title_3')->nullable();
            }
            if(!Schema::hasColumn('blocks','content_3')){
                $table->text('content_3')->nullable();
            }
            if(!Schema::hasColumn('blocks','title_4')){
                $table->text('title_4')->nullable();
            }
            if(!Schema::hasColumn('blocks','content_4')){
                $table->text('content_4')->nullable();
            }
            if(!Schema::hasColumn('blocks','title_5')){
                $table->text('title_5')->nullable();
            }
            if(!Schema::hasColumn('blocks','content_5')){
                $table->text('content_5')->nullable();
            }
            if(!Schema::hasColumn('blocks','title_6')){
                $table->text('title_6')->nullable();
            }
            if(!Schema::hasColumn('blocks','content_6')){
                $table->text('content_6')->nullable();
            }
            if(!Schema::hasColumn('blocks','image_1')){
                $table->string('image_1')->nullable();
            }
            if(!Schema::hasColumn('blocks','image_2')){
                $table->string('image_2')->nullable();
            }
            if(!Schema::hasColumn('blocks','image_3')){
                $table->string('image_3')->nullable();
            }
            if(!Schema::hasColumn('blocks','image_4')){
                $table->string('image_4')->nullable();
            }
            if(!Schema::hasColumn('blocks','image_5')){
                $table->string('image_5')->nullable();
            }
            if(!Schema::hasColumn('blocks','image_6')){
                $table->string('image_6')->nullable();
            }
            if(!Schema::hasColumn('blocks','video_url')){
                $table->text('video_url')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks', function (Blueprint $table) {
            if(Schema::hasColumn('blocks','slider_1_title')){
                $table->dropColumn('slider_1_title');
            }
            if(Schema::hasColumn('blocks','slider_1_sub_title')){
                $table->dropColumn('slider_1_sub_title');
            }
            if(Schema::hasColumn('blocks','slider_1_description')){
                $table->dropColumn('slider_1_description');
            }
            if(Schema::hasColumn('blocks','slider_2_title')){
                $table->dropColumn('slider_2_title');
            }
            if(Schema::hasColumn('blocks','slider_2_sub_title')){
                $table->dropColumn('slider_2_sub_title');
            }
            if(Schema::hasColumn('blocks','slider_2_description')){
                $table->dropColumn('slider_2_description');
            }
            if(Schema::hasColumn('blocks','slider_3_title')){
                $table->dropColumn('slider_3_title');
            }
            if(Schema::hasColumn('blocks','slider_3_sub_title')){
                $table->dropColumn('slider_3_sub_title');
            }
            if(Schema::hasColumn('blocks','slider_3_description')){
                $table->dropColumn('slider_3_description');
            }
            if(Schema::hasColumn('blocks','module_title_1')){
                $table->dropColumn('module_title_1');
            }
            if(Schema::hasColumn('blocks','module_content_1')){
                $table->dropColumn('module_content_1');
            }
            if(Schema::hasColumn('blocks','module_title_2')){
                $table->dropColumn('module_title_2');
            }
            if(Schema::hasColumn('blocks','module_content_2')){
                $table->dropColumn('module_content_2');
            }
            if(Schema::hasColumn('blocks','module_title_3')){
                $table->dropColumn('module_title_3');
            }
            if(Schema::hasColumn('blocks','module_content_3')){
                $table->dropColumn('module_content_3');
            }
        });
    }
}
