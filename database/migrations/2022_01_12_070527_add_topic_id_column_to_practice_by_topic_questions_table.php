<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTopicIdColumnToPracticeByTopicQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practice_by_topic_questions', function (Blueprint $table) {
            if(!Schema::hasColumn('practice_by_topic_questions','topic_id')){
                $table->unsignedBigInteger('topic_id')->nullable()->comment('pk of topics table');
                $table->foreign('topic_id')->references('id')->on('topics')
                ->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::table('practice_by_topic_questions', function (Blueprint $table) {
            if(Schema::hasColumn('practice_by_topic_questions','topic_id')){
                $table->dropForeign('practice_by_topic_questions_topic_id_foreign');
                $table->dropColumn('topic_id');
            }
        });
    }
}
