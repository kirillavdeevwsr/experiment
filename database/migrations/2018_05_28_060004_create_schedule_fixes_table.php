<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleFixesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_fixes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('period')->nullable();
            $table->string('branch')->nullable();
            $table->string('group')->nullable();
            $table->integer('subgroup')->nullable();
            $table->integer('week_type')->nullable();
            $table->integer('week_day')->nullable();
            $table->integer('lesson_position')->nullable();
            $table->string('discipline')->nullable();
            $table->string('teacher')->nullable();
            $table->string('room')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('schedule_fixes');
    }
}
