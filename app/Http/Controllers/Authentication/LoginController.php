<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function index(Request $request){
        $credentials = [
            'nama' => $request['email'],
            'password' => $request['password']

        ];

        $remember = $request->remember ? true : false;

        if(Auth::attempt($credentials , $remember )) {
            if(auth()->user()->bujp == 1) return redirect()->route('bujp');
            if(auth()->user()->administrator == 1 ) return redirect('administrator');
                return redirect()->route('home')->withErrors(['email' , 'some message']);
        } else {
            Alert::warning('Login Gagal!' , 'username atau password salah!');
            return redirect()->back();
        }
    }
}
