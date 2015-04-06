<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPositionsToPlayoffTeams extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('playoff_teams', function(Blueprint $table)
		{
			$table->smallInteger('team1_position')->after('team1_id');
			$table->smallInteger('team2_position')->after('team2_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('playoff_teams', function(Blueprint $table)
		{
			$table->dropColumn('team1_position');
			$table->dropColumn('team2_position');
		});
	}
}
