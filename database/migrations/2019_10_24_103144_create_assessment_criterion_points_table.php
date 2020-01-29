<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentCriterionPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_criterion_points', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('point');
            $table->integer('assessment_id')->unsigned();
        });

        Schema::table('assessment_criterion_points', function (Blueprint $table) {
            $table->foreign('assessment_id')->references('id')->on('assessment_list')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessment_criterion_points');

        Schema::table('assessment_criterion_points', function (Blueprint $table) {
            $table->dropForeign(['assessment_id']);
        });
    }
}
