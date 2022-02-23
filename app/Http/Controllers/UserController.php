<?php

namespace App\Http\Controllers;

use App\Models\{District, Division, User};
use Illuminate\Http\Request;
use File;
use Hash;

class UserController extends Controller
{
    public function profile()
    {
        return view('profile');
    }

    public function updateProfile(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'photo' => 'nullable|mimes:png,jpg,jpeg',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:8|confirmed'
        ],[
            'name.required' => 'Nama harus diisi !',
            'photo.mimes' => 'File yang diterima adalah png, jpg dan jpeg',
            'email.required' => 'Email harus diisi !',
            'email.email' => 'Email tidak valid !',
            'email.unique' => 'Email sudah dipakai !',
            'password.min' => 'Password minimal 8 karakter !',
            'password.confirmed' => 'Konfirmasi password salah !'
        ]);
        
        $user->name = $request->name;
        if($request->photo){
            $user->photo = $photo;
        }
        $user->email = $request->email;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect('/profile')->with('success', 'Profil berhasil diupdate !');
    }
}
