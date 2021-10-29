<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller
{
    /**
     * Google OAuth callback
     *
     */
    public function callbackGoogle(Request $request){
        try {
            $googleUser = Socialite::driver('google')->user();    
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            return view('welcome', ['msg'=>'login error']);
        }

        try {
            $user = User::where('email', $googleUser->email)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email
            ]);
        }
        $result = $this->loginUser($request, $user);
        if($result['status']){
            return redirect('/');
        }
        return view('welcome', ['msg'=>$result['msg']]);
    }

    /**
     * Goto google OAuth
     * If it is a local test, log in first user
     */
    public function loginGoogle(Request $request){
        if(__isLocal()){
            $user = User::where('id', 1)->first();
            $result = $this->loginUser($request, $user);
            if($result['status']){
                return redirect('/');
            }
            return view('welcome', ['msg'=>$result['msg']]);
        }
        $scopes = ['https://www.googleapis.com/auth/userinfo.email'];
        return Socialite::driver('google')->with(["prompt" => "select_account"])->scopes($scopes)->redirect();

    }

    /**
     * Use Demo user login
     *
     */
    public function loginDemo(Request $request){
        $user = User::where('id', 2)->first();
        $result = $this->loginUser($request, $user);
        if($result['status']){
            return redirect('/');
        }
        return view('welcome', ['msg'=>$result['msg']]);
    }

    /**
     * login user
     *
     * @param  User  $user
     * @return status
     */
    private function loginUser(Request $request, $user){
        Auth::login($user);
        // TBD: update user login info
        return ['status'=> true] ;
    }

    /**
     * Logout
     *
     * @param  User  $user
     * @return redirect to home
     */
    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
