<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function actionLogin(Request $request)
    {
        $dados = $request->only(['email', 'password']);

        if ($dados && $dados['email'] && $dados['password']) {

            if (Auth::attempt($dados)) {
                $request->session()->regenerate();
                return response()->json([
                    'success' => true,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Login e/ou senha inválidos.',
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Preencha todos os campos.',
            ]);
        }
    }

    public function sair()
    {
        Auth::logout();
        return redirect('/');
    }
}
