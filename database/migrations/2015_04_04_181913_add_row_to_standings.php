<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRowToStandings extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('standings', function(Blueprint $table)
		{
			$table->smallInteger('row')
				->after('pts')
			;
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('standings', function(Blueprint $table)
		{
			$table->dropColumn('row');
		});
	}
}
