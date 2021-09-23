<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class StartController extends Controller
{
    public function home(){
        $user = Auth::user();

        return view('start.start', compact('user'));
    }
}
