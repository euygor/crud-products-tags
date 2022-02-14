<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product_Tag;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdutosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => [
            'produtos',
            'searchProduto',
            'searchProdutoAction'
        ]]);
    }

    public function produtos()
    {
        $products = Product_Tag::orderBy('id', 'desc')->get();

        return view('dashboard.produtos', [
            'products' => $products,
        ]);
    }

    public function meusProdutos(Request $request)
    {
        $products = Product_Tag::where('idUser', Auth::user()->id)->get();
        $dados = [
            'success' => $request->session()->get('success'),
            'danger' => $request->session()->get('danger'),
            'warning' => $request->session()->get('warning'),
            'products' => $products
        ];

        return view('dashboard.meusProdutos', $dados);
    }

    public function meusProdutosAction(Request $request)
    {
        $dados = $request->only(['name', 'preco', 'descricao', 'tags']);
        $img = $request->file('img');

        if ($dados && $dados['name'] && $dados['preco'] && $dados['descricao'] && $dados['tags'] && $img) {
            $extension = $img->getClientOriginalExtension();
            if ($extension == 'jpg' || $extension == 'png' || $extension == 'jpeg') {
                if ($img->getSize() <= 5242880) {
                    $name = md5(time()) . '.' . $extension;
                    $product = new Product_Tag();
                    $product->idUser = Auth::user()->id;
                    $product->name = $dados['name'];
                    $product->descricao = $dados['descricao'];
                    $product->preco = $dados['preco'];
                    $product->img = $product->img != "" ? $product->img : $name;
                    $product->tags = $dados['tags'];
                    $product->qtdTags = count(explode('#', $dados['tags']));
                    $img->move('uploads/images', $product->img);
                    $product->save();

                    $request->session()->flash('success', 'Produto cadastrado com sucesso!');
                    return redirect()->route('meusProdutos');
                } else {
                    $request->session()->flash('warning', 'O tamanho máximo da imagem é 5MB.');
                    return redirect()->route('meusProdutos');
                }
            } else {
                $request->session()->flash('danger', 'Apenas as extensões jpg, png e jpeg são permitidas.');
                return redirect()->route('meusProdutos');
            }
        } else {
            $request->session()->flash('danger', 'Preencha todos os campos.');
            return redirect()->route('meusProdutos');
        }
    }

    public function meusProdutosUpdateAction(Request $request)
    {
        $dados = $request->only(['id', 'name', 'preco', 'descricao', 'tags']);
        $img = $request->file('img');

        if ($dados && $dados['name'] && $dados['preco'] && $dados['descricao'] && $dados['tags']) {
            if ($img) {
                $extension = $img->getClientOriginalExtension();
                if ($extension == 'jpg' || $extension == 'png' || $extension == 'jpeg') {
                    if ($img->getSize() <= 5242880) {
                        $name = md5(time()) . '.' . $extension;
                        $product = Product_Tag::find($dados['id']);
                        $product->idUser = Auth::user()->id;
                        $product->name = $dados['name'];
                        $product->descricao = $dados['descricao'];
                        $product->preco = $dados['preco'];
                        $product->img = $product->img != "" ? $product->img : $name;
                        $product->tags = $dados['tags'];
                        $product->qtdTags = count(explode('#', $dados['tags']));
                        $img->move('uploads/images', $product->img);
                        $product->save();

                        $request->session()->flash('success', 'Produto atualizado com sucesso!');
                        return redirect()->route('meusProdutos');
                    } else {
                        $request->session()->flash('warning', 'O tamanho máximo da imagem é 5MB.');
                        return redirect()->route('meusProdutos');
                    }
                } else {
                    $request->session()->flash('danger', 'Apenas as extensões jpg, png e jpeg são permitidas.');
                    return redirect()->route('meusProdutos');
                }
            } else {
                $product = Product_Tag::find($dados['id']);
                $product->idUser = Auth::user()->id;
                $product->name = $dados['name'];
                $product->descricao = $dados['descricao'];
                $product->preco = $dados['preco'];
                $product->tags = $dados['tags'];
                $product->qtdTags = count(explode('#', $dados['tags']));
                $product->save();

                $request->session()->flash('success', 'Produto atualizado com sucesso!');
                return redirect()->route('meusProdutos');
            }
        } else {
            $request->session()->flash('danger', 'Preencha todos os campos.');
            return redirect()->route('meusProdutos');
        }
    }

    public function meusProdutosDeleteAction(Request $request, $id)
    {
        if (Auth::check()) {
            $product = Product_Tag::find($id);
            if ($product->img != "") {
                if (file_exists('uploads/images/' . $product->img)) {
                    unlink('uploads/images/' . $product->img);
                }
            }
            $product->delete();

            $request->session()->flash('success', 'Produto excluído com sucesso!');
            return redirect()->route('meusProdutos');
        } else {
            return redirect()->route('login');
        }
    }

    public function searchProduto(Request $request, $slug)
    {
        $products = Product_Tag::where('tags', 'like', '%' . $slug . '%')->orWhere('name', 'like', '%' . $slug . '%')->get();

        return view('dashboard.searchProduto', [
            'products' => $products
        ]);
    }

    public function searchProdutoAction(Request $request)
    {
        $dados = $request->only(['search']);

        if ($dados && $dados['search']) {
            return redirect()->route('searchProduto', ['slug' => $dados['search']]);
        } else {
            return redirect()->route('home');
        }
    }

    public function gerarRelatorio(Request $request)
    {
        $products = Product_Tag::orderBy('qtdTags', 'desc')->get();
        $date = date('H:m:s d/m/Y');
        $pdf = PDF::loadView('dashboard.relatorio', ['products' => $products, 'date' => $date]);

        return $pdf->setPaper('a4')->stream(md5(rand(1, 9999)) . '.pdf');
    }
}
