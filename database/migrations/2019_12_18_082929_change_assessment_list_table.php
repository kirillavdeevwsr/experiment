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
        Schema::table('assessment_list', function(Blueprint $table){
            $table->dropColumn('criterion_assessment');
            $table->integer('multiple_select')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assessment_list', function(Blueprint $table){
            $table->dropColumn('multiple_select');
            $table->text('criterion_assessment');
        });

    }
}
