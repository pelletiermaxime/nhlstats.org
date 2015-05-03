<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoundToPlayoffChoices extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('playoff_choices', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->smallInteger('round')->default(1);
			$table->index(['round']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('playoff_choices', function(Blueprint $table)
		{
			$table->dropColumn('round');
		});
	}
}
