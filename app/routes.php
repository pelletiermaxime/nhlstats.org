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

Route::group(['prefix' => 'pool'], function()
{
	Route::get('me', [
		'as'    => 'pool/me',
		'uses'  => 'StandingsController@wildcard',
		'after' => 'cache:300',
	]);
});

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

// Confide routes
Route::get( 'user/create',                 'UserController@create');
Route::post('user',                        'UserController@store');
Route::get( 'user/login',                  'UserController@login');
Route::post('user/login',                  'UserController@do_login');
Route::get( 'user/confirm/{code}',         'UserController@confirm');
Route::get( 'user/forgot_password',        'UserController@forgot_password');
Route::post('user/forgot_password',        'UserController@do_forgot_password');
Route::get( 'user/reset_password/{token}', 'UserController@reset_password');
Route::post('user/reset_password',         'UserController@do_reset_password');
Route::get( 'user/logout',                 'UserController@logout');
