<?php
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
	'as'    => 'goalers',
	'uses'  => 'GoalerController@getListFiltered',
	'after' => 'cache:300',
]);

Route::group(['prefix' => 'standings'], function()
{
	Route::get('/', [
		'as'    => 'standings',
		'uses'  => 'StandingsController@overall',
		'after' => 'cache:300',
	]);

	Route::get('overall', [
		'as'    => 'standings_overall',
		'uses'  => 'StandingsController@overall',
		'after' => 'cache:300',
	]);

	Route::get('division', [
		'as'    => 'standings_division',
		'uses'  => 'StandingsController@division',
		'after' => 'cache:300',
	]);

	Route::get('wildcard', [
		'as'    => 'standings_wildcard',
		'uses'  => 'StandingsController@wildcard',
		'after' => 'cache:300',
	]);
});

Route::get('scores', [
	'as'    => 'scores',
	'uses'  => 'ScoresController@index',
	'after' => 'cache:30',
]);
