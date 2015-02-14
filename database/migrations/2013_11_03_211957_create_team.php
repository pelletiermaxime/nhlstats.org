<?php
use Illuminate\Database\Migrations\Migration;

class CreateTeam extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('teams', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('short_name');
			$table->string('city');
			$table->string('name');
			$table->smallInteger('year');
			$table->timestamps();

			$table->index(['short_name']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('teams');
	}

}