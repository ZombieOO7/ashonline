<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourceGuidancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_guidances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('title')->nullable();
            $table->string('slug')->unique();
            $table->unsignedBigInteger('resource_category_id')->nullable();
            $table->foreign('resource_category_id')->references('id')->on('resource_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('paper_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->string('featured_original_name')->nullable()->comment('Featured image original name');
            $table->string('featured_stored_name')->nullable()->comment('Featured image stored name');
            $table->longText('content')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->tinyInteger('status')->default('1')->comment = '0 Inactive/1 active';
            $table->unsignedBigInteger('written_by')->nullable()->comment('pk of admins');
            $table->foreign('written_by')->references('id')->on('admins')->onUpdate('cascade')->onDelete('cascade');
            $table->string('order_seq')->nullable();
            $table->tinyInteger('project_type')->default('0')->comment = '0 = paper, 1 = mock & 2 = practice';
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resource_guidances');
    }
}
