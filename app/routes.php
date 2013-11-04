<?php
// Route::get('/', function()
// {
// 	return View::make('hello');
// });

// Route::get('index', 'HomeController@showWelcome');

Route::get('/', array(
	'as' => 'index',
	'uses' => 'PlayerController@getListFiltered'
));

Route::get('filter', array(
	'as' => 'players_filtered',
	'uses' => 'PlayerController@getListFiltered',
));
// Route::controller('/', 'PlayerController');