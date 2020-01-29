<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollegeGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_groups', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('ref_key')->unique();
            $table->string('specialty_ref_key');
            $table->string('department_ref_key');
            $table->string('name');
            $table->string('status');
            $table->string('form_training');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('college_groups');
    }
}
