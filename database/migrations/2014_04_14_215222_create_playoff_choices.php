<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayoffChoices extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('playoff_choices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('playoff_team_id')->nullable();
            $table->unsignedInteger('winning_team_id')->nullable();
            $table->unsignedInteger('games')->nullable();

            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('playoff_team_id')->references('id')->on('playoff_teams')->onDelete('cascade');
            $table->foreign('winning_team_id')->references('id')->on('teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('playoff_choices');
    }
}
