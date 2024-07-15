<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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

                return redirect()->route("dashboard", ["user_id" => $new_user->id]);
            } else{
                return redirect()->route("dashboard", ["user_id" => $user->id]);
            }
            

        } catch(\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function dashboard($user_id){
        $user = User::find($user_id);

        return view("dashboard", compact("user"));
    }
}
