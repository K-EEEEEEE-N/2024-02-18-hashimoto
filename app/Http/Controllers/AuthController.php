<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getRegister()
    {
        return view('register');
    }

    public function postRegister(Request $request)
    {
        $validate_rule = [
            'name' => ['required'],
            'email' => ['required','email'],
            'password' => ['required','min:8','confirmed'],
            'password_confirmation' => ['required']
        ];
        $this->validate($request, $validate_rule);
        try {
            User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
            return redirect('login')->with('result', '会員登録が完了しました');
        } catch (\Throwable $th) {
            return redirect('register')->with('result', 'エラーが発生しました');
        }
    }

    public function getLogin()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $validate_rule = [
            'email' => ['required','email'],
            'password' => ['required','min:8'],
        ];
        $this->validate($request, $validate_rule);
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return redirect('/');
        } else {
            return redirect('login')->with('result', 'メールアドレスまたはパスワードが間違っております');
        }
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect("login");
    }
}