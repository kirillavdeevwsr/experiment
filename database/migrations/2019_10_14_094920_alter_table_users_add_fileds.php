<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableUsersAddFileds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->increments('id')->unsigned()->change();
            $table->string('login')->nullable();
            $table->integer('additional_information')->unsigned()->nullable();
            $table->foreign('additional_information')->references('id')->on('additional_information')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropForeign(['additional_information']);
            $table->dropColumn(['login', 'additional_information']);
        });
    }
}
