<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MinhaContaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => []]);
    }

    public function minhaConta(Request $request)
    {
        return view('dashboard.minhaConta', [
            'success' => $request->session()->get('success'),
            'danger' => $request->session()->get('danger'),
            'warning' => $request->session()->get('warning'),
        ]);
    }

    public function actionMinhaConta(Request $request)
    {
        $dados = $request->only(['name', 'email', 'password']);
        $avatar = $request->file('file');

        if ($dados && $dados['name'] && $dados['email']) {

            $verifyEmail = User::where('email', $dados['email'])->count();

            if ($verifyEmail > 0 && $dados['email'] != Auth::user()->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'E-mail já cadastrado.',
                ]);
            }

            $user = User::find(Auth::user()->id);
            $user->name = $dados['name'];
            $user->email = $dados['email'];

            if ($dados['password']) {
                $user->password = password_hash($dados['password'], PASSWORD_DEFAULT);
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Dados atualizados com sucesso!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Preencha todos os campos.',
            ]);
        }
    }

    public function actionMinhaContaAvatar(Request $request)
    {
        $avatar = $request->file('file');
        if ($avatar) {
            $extension = $avatar->getClientOriginalExtension();
            if ($extension == 'jpg' || $extension == 'png' || $extension == 'jpeg') {
                if ($avatar->getSize() <= 5242880) {
                    $name = md5(time()) . '.' . $extension;
                    $user = User::find(Auth::user()->id);
                    $user->avatar = $user->avatar != "" ? $user->avatar : $name;
                    $avatar->move('uploads/avatar', $user->avatar);
                    $user->save();

                    $request->session()->flash('success', 'Avatar atualizado com sucesso!');
                    return redirect()->route('minhaConta');
                } else {
                    $request->session()->flash('warning', 'O tamanho máximo da imagem é 5MB.');
                    return redirect()->route('minhaConta');
                }
            } else {
                $request->session()->flash('danger', 'Apenas as extensões jpg, png e jpeg são permitidas.');
                return redirect()->route('minhaConta');
            }
        } else {
            return redirect()->route('minhaConta');
        }
    }
}
