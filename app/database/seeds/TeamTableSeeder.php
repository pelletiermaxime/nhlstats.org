<?php

class TeamTableSeeder extends Seeder {

	public function run()
	{
		Team::whereYear('1314')->delete();

		$team = new Team();
		$timestamp = $team->freshTimestamp();

		$atlantic_division = Division::whereDivision('ATLANTIC')->pluck('id');
		$metropolitan_division = Division::whereDivision('METROPOLITAN')->pluck('id');
		$central_division = Division::whereDivision('CENTRAL')->pluck('id');
		$pacific_division = Division::whereDivision('PACIFIC')->pluck('id');

		DB::table('teams')->insert([
			['short_name' => 'DET', 'city' => 'Detroit', 'name' => 'Red Wings', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $atlantic_division],
			['short_name' => 'TOR', 'city' => 'Toronto', 'name' => 'Maple leafs', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $atlantic_division],
			['short_name' => 'CGY', 'city' => 'Calgary', 'name' => 'Flames', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $pacific_division],
			['short_name' => 'COL', 'city' => 'Colorado', 'name' => 'Avalanche', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $central_division],
			['short_name' => 'LAK', 'city' => 'Los Angeles', 'name' => 'Kings', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $pacific_division],
			['short_name' => 'CBJ', 'city' => 'Columbus', 'name' => 'Blue Jackets', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $metropolitan_division],
			['short_name' => 'OTT', 'city' => 'Ottawa', 'name' => 'Senators', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $atlantic_division],
			['short_name' => 'CHI', 'city' => 'Chicago', 'name' => 'Blackhawks', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $central_division],
			['short_name' => 'CAR', 'city' => 'Carolina', 'name' => 'Hurricanes', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $metropolitan_division],
			['short_name' => 'PHI', 'city' => 'Philadelphia', 'name' => 'Flyers', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $metropolitan_division],
			['short_name' => 'PIT', 'city' => 'Pittsburgh', 'name' => 'Penguins', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $metropolitan_division],
			['short_name' => 'TBL', 'city' => 'Tampa Bay', 'name' => 'Lightning', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $atlantic_division],
			['short_name' => 'STL', 'city' => 'St Louis', 'name' => 'Blues', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $central_division],
			['short_name' => 'MIN', 'city' => 'Minnesota', 'name' => 'Wild', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $central_division],
			['short_name' => 'NYI', 'city' => 'New York', 'name' => 'Islanders', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $metropolitan_division],
			['short_name' => 'WSH', 'city' => 'Washington', 'name' => 'Capitals', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $metropolitan_division],
			['short_name' => 'FLA', 'city' => 'Florida', 'name' => 'Panthers', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $atlantic_division],
			['short_name' => 'DAL', 'city' => 'Dallas', 'name' => 'Stars', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $central_division],
			['short_name' => 'SJS', 'city' => 'San Jose', 'name' => 'Sharks', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $pacific_division],
			['short_name' => 'BUF', 'city' => 'Buffalo', 'name' => 'Sabres', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $atlantic_division],
			['short_name' => 'EDM', 'city' => 'Edmonton', 'name' => 'Oilers', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $pacific_division],
			['short_name' => 'NYR', 'city' => 'New York', 'name' => 'Rangers', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $metropolitan_division],
			['short_name' => 'VAN', 'city' => 'Vancouver', 'name' => 'Canucks', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $pacific_division],
			['short_name' => 'BOS', 'city' => 'Boston', 'name' => 'Bruins', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $atlantic_division],
			['short_name' => 'WPG', 'city' => 'Winnipeg', 'name' => 'Jets', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $central_division],
			['short_name' => 'MTL', 'city' => 'Montreal', 'name' => 'Canadiens', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $atlantic_division],
			['short_name' => 'NSH', 'city' => 'Nashville', 'name' => 'Predators', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $central_division],
			['short_name' => 'ANA', 'city' => 'Anaheim', 'name' => 'Ducks', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $pacific_division],
			['short_name' => 'PHX', 'city' => 'Phoenix', 'name' => 'Coyotes', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $pacific_division],
			['short_name' => 'NJD', 'city' => 'New Jersey', 'name' => 'Devils', 'year' => '1314',
				'created_at' => $timestamp, 'updated_at' => $timestamp, 'division_id' => $metropolitan_division],
		]);
	}
}
