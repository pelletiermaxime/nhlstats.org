<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayersStatsYear extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('players_stats_years', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('player_id')->unsigned()->nullable();

			$table->smallInteger('games');
			$table->smallInteger('goals');
			$table->smallInteger('assists');
			$table->smallInteger('points');
			$table->smallInteger('plusminus');
			$table->smallInteger('pim');
			$table->smallInteger('pp');
			$table->smallInteger('sh');
			$table->smallInteger('gw');
			$table->smallInteger('ot');
			$table->smallInteger('s');
			$table->smallInteger('spourcent');
			$table->smallInteger('TOIG');
			$table->smallInteger('SftG');
			$table->smallInteger('FOPourcent');

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
		Schema::drop('players_stats_years');
	}

}
