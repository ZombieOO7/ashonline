<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('google_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->double('amount_1')->nullable();
            $table->double('amount_2')->nullable();
            $table->double('discount_1')->nullable();
            $table->double('discount_2')->nullable();
            $table->string('code')->nullable();
            $table->string('rating_mail')->nullable();
            $table->tinyInteger('code_status')->default('1')->comment = '0 NO/1 YES';
            $table->string('notification_content')->nullable();
            $table->tinyInteger('project_type')->default('0')->comment = '0 = paper, 1 = mock & 2 = practice';
            $table->string('notification_interval')->nullable();
            $table->tinyInteger('send_email')->default('1')->comment = '0 = On, 1= Off';
            $table->tinyInteger('mode')->default('1')->comment = '0 = Test Mode, 1= Live Mode';
            $table->string('live_key')->nullable();
            $table->string('live_secret_key')->nullable();
            $table->string('test_key')->nullable();
            $table->string('test_secret_key')->nullable();
            $table->string('smtp_host')->nullable();
            $table->string('smtp_username')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('smtp_driver')->nullable();
            $table->string('smtp_encryption')->nullable();
            $table->string('mail_from')->nullable();
            $table->string('interval_days')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_settings');
    }
}
