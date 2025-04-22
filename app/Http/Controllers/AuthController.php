<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Exception;
use DB;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.auth.login', [
            'layout' => 'base'
        ]);
        //return view('auth.login');
    }

    public function login(Request $request)
    {
        $email_username = $request->input('email');
        $password = $request->input('password');
        $credentials = array();
        
        $email = collect(\DB::select("SELECT
                EMAIL
            FROM
                USERS
            WHERE
                USERNAME = :email_username
                OR EMAIL = :email_username",
        ["email_username" => $email_username]))->first();

        //$credentials = $request->only('email', 'password');

        if(!empty($email)){
            $credentials = [
                'email' => $email->email,
                'password' => $password
            ];
        }

        //throw New Exception($email->email);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/'); // o cualquier ruta
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
