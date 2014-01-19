<?php
// Route::get('/', function()
// {
// 	return View::make('hello');
// });

// Route::get('index', 'HomeController@showWelcome');

Route::get('/', [
	'as'    => 'index',
	'uses'  => 'PlayerController@getListFiltered',
	'after' => 'cache:300',
]);

Route::get('player', [
	'as'   => 'players_filtered',
	'uses' => 'PlayerController@getListFiltered',
]);

Route::get('goalers', [
	'as'   => 'goalers',
	'uses' => 'GoalerController@getListFiltered',
	'after' => 'cache:300',
]);

Route::get('standings', [
	'as'    => 'standings',
	'uses'  => 'StandingsController@index',
	'after' => 'cache:300',
]);

// Route::controller('/', 'PlayerController');