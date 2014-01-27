<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayersStatsDays extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('players_stats_days', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('player_id')->unsigned()->nullable();
			$table->date('day')->index();

			$table->smallInteger('goals');
			$table->smallInteger('assists');
			$table->smallInteger('points');
			$table->smallInteger('plusminus');

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
		Schema::drop('players_stats_days');
	}
}
