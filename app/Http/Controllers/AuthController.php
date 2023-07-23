<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        if (Auth::guard('pegawai')->attempt(['user_name' => $request->user_name, 'password' => $request->password])) {
            return Redirect::route('dashboard');
        } else {
            return Redirect::route('login')->with(['error' => 'Usermane / Password salah.']);
        }

    }

    public function Logout()
    {
        if (Auth::guard('pegawai')->check()) {
            Auth::guard('pegawai')->logout();
            return redirect('/');
        }
    }
    public function adminlogin(Request $request)
    {
        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return Redirect('/admin/adminindex');
        } else {
            return Redirect('/admin')->with(['error' => 'Email / Password salah.']);
        }

    }
    public function adminLogout()
    {
        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
            return redirect('/admin');
        }
    }
}
