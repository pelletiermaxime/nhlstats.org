<?php
// Route::get('/', function()
// {
// 	return View::make('hello');
// });

// Route::get('index', 'HomeController@showWelcome');

Route::get('/', 'PlayerController@getList');
Route::controller('/', 'PlayerController');