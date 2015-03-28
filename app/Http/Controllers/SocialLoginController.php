<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;

class SocialLoginController extends Controller
{
	public function login()
	{
		return \Socialize::with('github')->redirect();
	}

	public function logged_in()
	{
		$userData = \Socialize::with('github')->user();

		$user = User::firstOrNew([
			'username' => $userData->nickname,
		]);
		$user->email = $userData->email;
		$user->save();

		\Auth::login($user);
		return \Redirect::to('/');
	}

	public function logout()
	{
		\Auth::logout();
		return \Redirect::to('/');
	}
}
