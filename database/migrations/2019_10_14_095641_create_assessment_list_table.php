<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_list', function (Blueprint $table) {
            $table->increments('id');
            $table->text('criterion'); // критерии
            $table->text('criterion_assessment'); //критерии оценки
            $table->integer('responsible_id')->unsigned(); //id пользователя ответственного
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessment_list');
    }
}
