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

Route::get('standings', [
	'as'    => 'standings',
	'uses'  => 'StandingsController@overall',
	'after' => 'cache:300',
]);

Route::get('standings/overall', [
	'as'    => 'standings_overall',
	'uses'  => 'StandingsController@overall',
	'after' => 'cache:300',
]);

Route::get('standings/division', [
	'as'    => 'standings_division',
	'uses'  => 'StandingsController@division',
	'after' => 'cache:300',
]);

Route::get('scores', [
	'as'    => 'scores',
	'uses'  => 'ScoresController@index',
	'after' => 'cache:30',
]);
