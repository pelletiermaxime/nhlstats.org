<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGameScores extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('game_scores', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->unsignedInteger('team1_id')->nullable();
            $table->tinyInteger('score1_1')->unsigned()->nullable();
            $table->tinyInteger('score1_2')->unsigned()->nullable();
            $table->tinyInteger('score1_3')->unsigned()->nullable();
            $table->tinyInteger('score1_OT')->unsigned()->nullable();
            $table->tinyInteger('score1_SO')->unsigned()->nullable();
            $table->tinyInteger('score1_T')->unsigned()->nullable();

            $table->unsignedInteger('team2_id')->nullable();
            $table->tinyInteger('score2_1')->unsigned()->nullable();
            $table->tinyInteger('score2_2')->unsigned()->nullable();
            $table->tinyInteger('score2_3')->unsigned()->nullable();
            $table->tinyInteger('score2_OT')->unsigned()->nullable();
            $table->tinyInteger('score2_SO')->unsigned()->nullable();
            $table->tinyInteger('score2_T')->unsigned()->nullable();

            $table->date('date_game');
            $table->unsignedInteger('year');

            $table->timestamps();
            $table->foreign('team1_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('team2_id')->references('id')->on('teams')->onDelete('cascade');
            $table->index(['date_game', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('game_scores');
    }
}
