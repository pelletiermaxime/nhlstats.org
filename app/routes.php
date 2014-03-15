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
	'uses'  => 'StandingsController@index',
	'after' => 'cache:300',
]);

Route::get('scores', [
	'as'    => 'scores',
	'uses'  => 'ScoresController@index',
	'after' => 'cache:30',
]);

Route::get('playoff-bracket', [
	'as'    => 'playoff_bracket',
	'uses'  => 'PlayoffBracketController@index',
	'after' => 'cache:30',
]);
