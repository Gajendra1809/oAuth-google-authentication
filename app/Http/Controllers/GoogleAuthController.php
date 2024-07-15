<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use League\OAuth1\Client\Credentials\Credentials;

class GoogleAuthController extends Controller
{
    public function redirect(){
        return Socialite::driver("google")->redirect();
    }

    public function callbackGoogle(){
        try {
            $google_user = Socialite::driver("google")->user();
            $user = User::where("email", $google_user->getEmail())->first();
            if(!$user){
                $new_user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),
                ]);
                Auth::login($new_user);
            } else{
                Auth::login($user);
            }
            return redirect()->route("dashboard");
            

        } catch(\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function dashboard(){
        $user = User::find(auth()->user()->id);

        return view("dashboard", compact("user"));
    }

    public function logout(){
        Auth::logout();
        return redirect()->route("login");
    }
}
