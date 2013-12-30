<?php
// Route::get('/', function()
// {
// 	return View::make('hello');
// });

// Route::get('index', 'HomeController@showWelcome');

Route::get('/', [
	'as'   => 'index',
	'uses' => 'PlayerController@getListFiltered',
	'after' => 'cache:30'
]);

Route::get('filter', [
	'as'   => 'players_filtered',
	'uses' => 'PlayerController@getListFiltered',
]);

Route::get('standings', [
	'as'   => 'standings',
	'uses' => 'StandingsController@index'
]);

// Route::controller('/', 'PlayerController');