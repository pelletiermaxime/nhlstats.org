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

Route::get('player/{id}/{name}', [
	'as'   => 'player_page',
	'uses' => 'PlayerPageController@index',
])
->where('id', '[0-9]+');
;

Route::get('goalers', [
	'as'    => 'goalers',
	'uses'  => 'GoalerController@getListFiltered',
	'after' => 'cache:300',
]);

Route::group(['prefix' => 'team'], function ()
{
	Route::get('/', [
		'as'   => 'teams',
		'uses' => 'TeamController@index',
	]);
	Route::get('/{team}', [
		'as'   => 'team',
		'uses' => 'TeamController@show',
	]);
});

Route::group(['prefix' => 'standings'], function ()
{
	Route::get('overall', [
		'as'    => 'standings',
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
		'as'    => 'pool_me',
		'uses'  => 'PoolController@edit',
	]);

	Route::post('me', [
		'as'    => 'pool_save',
		'uses'  => 'PoolController@store',
	]);

	Route::get('', [
		'as'    => 'pool_index',
		'uses'  => 'PoolController@index',
	]);
});

Route::get('scores/{date?}', [
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
Route::get('user/create', [
	'as'    => 'user_create',
	'uses'  => 'UserController@create',
]);
Route::post('user',                        'UserController@store');
Route::get('user/login', [
	'as'    => 'user_login',
	'uses'  => 'UserController@login',
]);
Route::post('user/login',                  'UserController@doLogin');
Route::get( 'user/confirm/{code}',         'UserController@confirm');
Route::get( 'user/forgot_password',        'UserController@forgotPassword');
Route::post('user/forgot_password',        'UserController@doForgotPassword');
Route::get( 'user/reset_password/{token}', 'UserController@resetPassword');
Route::post('user/reset_password',         'UserController@doResetPassword');
Route::get('user/logout', [
	'as'    => 'user_logout',
	'uses'  => 'UserController@logout',
]);
