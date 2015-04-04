<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddYearToPlayoffChoices extends Migration
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
			$table->smallInteger('year');
			$table->index(['year']);
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
			$table->dropColumn('year');
		});
	}
}
