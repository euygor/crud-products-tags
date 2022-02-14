<?php

use App\Http\Controllers\CadastroController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\dashboard\MinhaContaController;
use App\Http\Controllers\dashboard\ProdutosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'actionLogin'])->name('actionLogin');
Route::get('/sair', [LoginController::class, 'sair'])->name('sair');

Route::get('/cadastro', [CadastroController::class, 'cadastro'])->name('cadastro');
Route::post('/cadastro', [CadastroController::class, 'actionCadastro'])->name('actionCadastro');

Route::get('/minha-conta', [MinhaContaController::class, 'minhaConta'])->name('minhaConta');
Route::post('/minha-conta', [MinhaContaController::class, 'actionMinhaConta'])->name('actionMinhaConta');
Route::post('/minha-conta/avatar', [MinhaContaController::class, 'actionMinhaContaAvatar'])->name('actionMinhaContaAvatar');

Route::get('/meus-produtos', [ProdutosController::class, 'meusProdutos'])->name('meusProdutos');
Route::post('/meus-produtos', [ProdutosController::class, 'meusProdutosAction'])->name('meusProdutosAction');
Route::post('/meus-produtos-update', [ProdutosController::class, 'meusProdutosUpdateAction'])->name('meusProdutosUpdateAction');
Route::get('/meus-produtos-delete/{id}', [ProdutosController::class, 'meusProdutosDeleteAction'])->name('meusProdutosDeleteAction');

Route::get('/produtos', [ProdutosController::class, 'produtos'])->name('produtos');

Route::get('/search-produto/{slug}', [ProdutosController::class, 'searchProduto'])->name('searchProduto');
Route::post('/search-produto', [ProdutosController::class, 'searchProdutoAction'])->name('searchProdutoAction');

Route::get('/gerar-relatorio', [ProdutosController::class, 'gerarRelatorio'])->name('gerarRelatorio');
