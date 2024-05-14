<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginSiswaController extends Controller
{
    public function index(){
        return view('auth.login-siswa');
    }

    public function login(Request $request){

        $siswa = User::where('id', $request->nisn)->first();
        if(!$siswa){
            return redirect()->route('login-siswa.index')->with('error', 'NISN atau kata sandi salah!');
        }

        if($siswa->role != 'siswa'){
            return view('auth.login');
        }

        $request->validate([
            'nisn' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('id', $request->nisn)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Autentikasi pengguna
            Auth::login($user);
            return redirect()->route('dashboard-siswa.index');
        } else {
            return redirect()->route('login-siswa.index')->with('error', 'NISN atau kata sandi salah!');
        }
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect()->route('login-siswa.index');
    }
}
