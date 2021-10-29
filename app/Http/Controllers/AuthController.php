<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function callbackGoogle(Request $request){
        try {
            $googleUser = Socialite::driver('google')->user();    
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            dd($e);
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

    public function loginGoogle(Request $request){
        // if(__isLocal()){
        //     $user = User::where('id', 1)->first();
        //     $result = $this->loginUser($request, $user);
        //     if($result['status']){
        //         return redirect('/');
        //     }
        //     return view('welcome', ['msg'=>$result['msg']]);
        // }
        $scopes = ['https://www.googleapis.com/auth/userinfo.email'];
        return Socialite::driver('google')->with(["prompt" => "select_account"])->scopes($scopes)->redirect();

    }

    public function loginDemo(Request $request){
        $user = User::where('id', 2)->first();
        $result = $this->loginUser($request, $user);
        if($result['status']){
            return redirect('/');
        }
        return view('welcome', ['msg'=>$result['msg']]);
    }

    private function loginUser(Request $request, $user){
        Auth::login($user);
        return ['status'=> true] ;
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/');
    }
}
