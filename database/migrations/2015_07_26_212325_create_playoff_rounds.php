<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayoffRounds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playoff_rounds', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->unsignedInteger('round');
            $table->date('date_start');
            $table->date('date_end');
            $table->unsignedInteger('year');

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
        Schema::drop('playoff_rounds');
    }
}
