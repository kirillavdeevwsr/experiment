<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionalStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_student', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('ref_key_profile');
            $table->string('ref_key_student');
            $table->string('ref_key_department');
            $table->string('ref_key_specialty');
            $table->string('ref_key_group');
            $table->timestamp('birthday');
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
        Schema::dropIfExists('additional_student');
    }
}
