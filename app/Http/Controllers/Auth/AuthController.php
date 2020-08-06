<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * 从 GitHub 获取用户信息
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback()
    {
//        $user = Socialite::driver('github')->user();
        // $user->token;

        try {
            $user = Socialite::driver('github')->user();
        } catch (Exception $e) {
            return Redirect::to('login/github');
        }

        $authUser = $this->findOrCreateUser($user);
//        dd($user);
        Auth::login($authUser, true);
        return redirect('/home');
    }

    private function findOrCreateUser($githubUser)
    {
        if ($authUser = User::where('github_id', $githubUser->id)->first()) {
            return $authUser;
        }
        else if ($authUser = User::where('email', $githubUser->email)->first()) {
            User::where('email', $githubUser->email)->update(['github_id' => $githubUser->id]);
            return $authUser;
        }

        return User::create([
            'name' => $githubUser->nickname,
            'email' => $githubUser->email,
            'github_id' => $githubUser->id,
            'password' => '/',
            'email_verified_at' => time()
        ]);
    }
}
