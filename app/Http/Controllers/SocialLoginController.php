<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;

class SocialLoginController extends Controller
{
	public function login()
	{
		return view('login/select');
	}

	public function doLogin($type)
	{
		return \Socialize::with($type)->redirect();
	}

	public function logged_in($type)
	{
		$userData = \Socialize::with($type)->user();
		$username = $userData->nickname;
		if (empty($username)) {
			$username = $userData->email;
		}
		$user = User::firstOrNew([
			'username' => $username,
			'email'    => $userData->email,
		]);
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
