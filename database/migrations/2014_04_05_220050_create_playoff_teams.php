<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayoffTeams extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('playoff_teams', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->unsignedInteger('team1_id')->nullable();
            $table->unsignedInteger('team2_id')->nullable();
            $table->string('conference');
            $table->unsignedInteger('round');

            $table->timestamps();
            $table->foreign('team1_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('team2_id')->references('id')->on('teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('playoff_teams');
    }
}
