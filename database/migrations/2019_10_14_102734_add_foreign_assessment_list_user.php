<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignAssessmentListUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assessment_list_user', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('assessment_id')->references('id')->on('assessment_list');
            $table->foreign('status_id')->references('id')->on('statuses');
        });

        Schema::table('assessment_list', function(Blueprint $table) {
           $table->foreign('responsible_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assessment_list_user', function(Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeign(['assessment_id']);
            $table->dropForeign(['status_id']);
        });

        Schema::table('assessment_list', function(Blueprint $table) {
            $table->dropForeign(['responsible_id']);
        });
    }
}
