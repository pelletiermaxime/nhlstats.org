<?php

class TeamTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('team')->truncate();

		$team = [
			'short_name' => 'DET',
			'city'       => 'Detroit',
			'name'       => 'Red Wings',
			'year'       => '1314'
		];

		// Uncomment the below to run the seeder
		DB::table('team')->insert($team);
	}

}
