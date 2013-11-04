<?php

use Illuminate\Database\Migrations\Migration;

class Add1314Teams extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$team = new Team;
		$team->short_name = 'DET';
		$team->city = 'Detroit';
		$team->name = 'Red Wings';
		$team->year = '1314';
		$team->save();

		// DB::table('roles')->insert(
		// [
		// 	['name' => 'admin'],
		// 	['name' => 'user'],
		// 	['name' => 'moderator'],
		// ]);

		// User::create([
		// 	'username' => 'john',
		// 	'password' => Hash::make('test'),
		// 	'role_id'  => $user_role
		// ]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	}

}