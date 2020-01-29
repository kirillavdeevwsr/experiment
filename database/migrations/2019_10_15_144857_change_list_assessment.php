<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeListAssessment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assessment_list', function(Blueprint $t) {
            $t->string('unit_of_measure'); //единица измерения
            $t->string('data_source'); //источник данных
            $t->string('summary_periodicity'); //переодичность подведения итогов
            $t->string('frequency_of_payment'); //переодичность выплат
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assessment_list', function(Blueprint $t) {
            $t->dropColumn('unit_of_measure'); //единица измерения
            $t->dropColumn('data_source'); //источник данных
            $t->dropColumn('summary_periodicity'); //переодичность подведения итогов
            $t->dropColumn('frequency_of_payment'); //переодичность выплат
        });
    }
}
