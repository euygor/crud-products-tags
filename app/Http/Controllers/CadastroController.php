<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CadastroController extends Controller
{
    public function cadastro()
    {
        return view('cadastro');
    }

    public function actionCadastro(Request $request)
    {
        $dados = $request->only(['name', 'email', 'password']);

        if ($dados && $dados['name'] && $dados['email'] && $dados['password']) {

            $verifyEmail = User::where('email', $dados['email'])->count();

            if ($verifyEmail > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'E-mail já cadastrado.',
                ]);
            }

            $user = new User();
            $user->name = $dados['name'];
            $user->email = $dados['email'];
            $user->password = password_hash($dados['password'], PASSWORD_DEFAULT);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Cadastro efetuado com sucesso!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Preencha todos os campos.',
            ]);
        }
    }
}
