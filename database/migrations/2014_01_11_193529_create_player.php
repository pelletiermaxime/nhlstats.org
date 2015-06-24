<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayer extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('team_id')->unsigned()->nullable();

            $table->string('first_name');
            $table->string('name');
            $table->string('full_name');
            $table->string('position');
            $table->string('number');
            $table->string('birthdate');
            $table->string('city');
            $table->string('country');
            $table->string('weight');
            $table->string('shoots');
            $table->boolean('rookie');
            $table->smallInteger('year');

            $table->timestamps();
            $table->foreign('team_id')->references('id')->on('teams');
            $table->index(['year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('players');
    }
}
