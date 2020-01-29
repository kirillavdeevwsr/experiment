<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("concept_id")->unsigned();
            $table->text("participants");
            $table->text("responsible");
            $table->text("place");
            $table->date("date");
            $table->text("description");
            $table->text("title");
            $table->text("preview");
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
        Schema::dropIfExists('journal_events');
    }
}
