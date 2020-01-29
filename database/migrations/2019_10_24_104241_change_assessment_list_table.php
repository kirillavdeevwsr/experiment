<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAssessmentListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assessment_list',function(Blueprint $table){
            $table->integer('summary_periodicity')->unsigned()->change();
            $table->integer('frequency_of_payment')->unsigned()->change();
            $table->boolean('multi_select')->default(false);
        });

        Schema::table('assessment_list',function(Blueprint $table){
            $table->foreign('summary_periodicity')->references('id')->on('assessment_periodicity');
            $table->foreign('frequency_of_payment')->references('id')->on('assessment_frequency_of_payment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assessment_list', function (Blueprint $table) {
            $table->dropForeign(['summary_periodicity']);
            $table->dropForeign(['frequency_of_payment']);
        });

        Schema::table('assessment_list', function (Blueprint $table) {
            $table->string('summary_periodicity')->change(); //переодичность подведения итогов
            $table->string('frequency_of_payment')->change(); //переодичность выплат
            $table->dropColumn('multi_select');
        });
    }
}
