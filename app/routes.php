<?php
// Route::get('/', function()
// {
// 	return View::make('hello');
// });

// Route::get('index', 'HomeController@showWelcome');

Route::get('/', array(
	'as' => 'index',
	'uses' => 'PlayerController@getList'
));
// Route::controller('/', 'PlayerController');