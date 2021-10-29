<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * visit home page
     *
     * @return view welcome
     */
    public function home(){
        $user = Auth::user();
        return view('welcome');
    }
}
