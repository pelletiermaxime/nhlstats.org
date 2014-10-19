<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGoalersStatsYear extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('goalers_stats_years', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('player_id')->unsigned()->nullable();

			$table->smallInteger('games')->unsigned();
			$table->smallInteger('shots_against')->unsigned();
			$table->smallInteger('goals_against')->unsigned();
			$table->smallInteger('win')->unsigned();
			$table->smallInteger('lose')->unsigned();
			$table->smallInteger('shootouts')->unsigned();
			$table->smallInteger('saves')->unsigned();
			$table->smallInteger('saves_pourcent')->unsigned();
			$table->smallInteger('goals')->unsigned();
			$table->smallInteger('assists')->unsigned();
			$table->smallInteger('pim')->unsigned();
			$table->float('goals_against_average')->unsigned();

			$table->foreign('player_id')->references('id')->on('players');
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
		Schema::drop('goalers_stats_years');
	}

}
