<?php

namespace Nhlstats\Http\Controllers;

use Nhlstats\User;
use Auth;
use Socialize;

class SocialLoginController extends Controller
{
    public function login()
    {
        return view('login/select');
    }

    public function doLogin($type)
    {
        if (App::environment('local')) {
            $user = User::first();
            Auth::login($user, true);
            redirect('/');
        }
        return Socialize::with($type)->redirect();
    }

    public function logged_in($type)
    {
        $userData = Socialize::with($type)->user();
        $username = $userData->nickname;
        if (empty($username)) {
            $username = $userData->email;
        }
        $user = User::firstOrNew([
            'username' => $username,
            'email'    => $userData->email,
        ]);
        $user->save();

        Auth::login($user, true);

        return redirect('/');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
