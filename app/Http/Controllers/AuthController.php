<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Quote;
use Illuminate\Support\Facades\Http;
use Facades\App\Http\Controllers\API\DataController;

class AuthController extends Controller
{
    public function logout()
    {
    	auth()->logout();
    	return redirect('/');
    }

    public function login()
    {
        if(auth()->user()){
            return redirect('/home');
        }

    	return view('auth.login');
    }

    public function auth(Request $request)
    {
        
    	$loginData = $request->validate([
            'email' => 'required',
            'password' => 'required|min:8'
        ],
        [
            'email.required' => 'Masukan email terlebih dahulu',
            'password.required' => 'Masukan password terlebih dahulu',
            'password.min' => 'Password minimal 8 karakter',
        ]);
        //dd($request);
        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->withErrors(['Email atau password yang anda masukan salah!']);
        }

        return redirect('/home')->with('success', 'Login Berhasil!');
    }

    public function register()
    {
        if(auth()->user()){
            return redirect('/home');
        }

    	return view('auth.register');
    }

    public function registerAuth(Request $request) {
        //dd($request);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed'
        ],[
            'name.required' => 'Nama tidak boleh kosong !',
            'email.required' => 'Email tidak boleh kosong !',
            'email.email' => 'Email tidak valid !',
            'email.unique' => 'Email sudah terdaftar !',
            'password.required' => 'Password tidak boleh kosong !',
            'password.required' => 'Password tidak valid !',
            'password.min' => 'Password minimal 8 karakter !',
            'password.confirmed' => 'Konfirmasi password tidak cocok !',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt(trim($request->password)),
        ]);

        return redirect('/login')->with('success', 'Berhasil daftar, silakan masuk!');
    }


    public function home(Request $request)
    {   
        $data = Quote::limit(5)->get();
        return view('home', compact('data'));
    }
}
