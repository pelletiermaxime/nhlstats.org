<?php

class DivisionsTableSeeder extends Seeder {

	public function run()
	{
		Team::truncate();
		Division::truncate();

		$division = new Division();
		$timestamp = $division->freshTimestamp();

		DB::table('divisions')->insert([
			['division' => 'ATLANTIC', 'conference' => 'EAST', 'year' => '1314', 'created_at' => $timestamp, 'updated_at' => $timestamp],
			['division' => 'METROPOLITAN', 'conference' => 'EAST', 'year' => '1314', 'created_at' => $timestamp, 'updated_at' => $timestamp],
			['division' => 'CENTRAL', 'conference' => 'WEST', 'year' => '1314', 'created_at' => $timestamp, 'updated_at' => $timestamp],
			['division' => 'PACIFIC', 'conference' => 'WEST', 'year' => '1314', 'created_at' => $timestamp, 'updated_at' => $timestamp],
		]);
	}

}
