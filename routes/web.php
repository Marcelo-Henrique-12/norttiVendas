<?php

use App\Http\Controllers\AuthAdmin\ForgotPasswordController;
use App\Http\Controllers\AuthAdmin\LoginController;
use App\Http\Controllers\AuthAdmin\ResetPasswordController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\HomeAdminController;
use App\Http\Controllers\Admin\PerfilAdminController;
use App\Http\Controllers\Admin\ProdutoAdminController;
use App\Http\Controllers\Admin\VendaAdminController;
use App\Http\Controllers\Clientes\CarrinhoController;
use App\Http\Controllers\Clientes\CompraController;
use App\Http\Controllers\Clientes\HomeController;
use App\Http\Controllers\Clientes\PerfilController;
use App\Http\Controllers\Clientes\ProdutoController;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfNotAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();


// Landing Page
Route::get('/', function () {
    return view('welcome');
});



// Rotas do cliente
Route::prefix('cliente')->name('cliente.')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');

    // Rotas que precisam de autenticação do usuário
    Route::middleware(Authenticate::class)->group(function () {
        Route::get('perfil', [PerfilController::class, 'index'])->name('perfil.index');
        Route::put('perfil/{user}', [PerfilController::class, 'update'])->name('perfil.update');

        Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('carrinho.index');
        Route::post('/carrinho/adicionar', [CarrinhoController::class, 'adicionarAoCarrinho'])->name('carrinho.adicionar');
        Route::post('/carrinho/atualizar/{produto}', [CarrinhoController::class, 'atualizarCarrinho'])->name('carrinho.atualizar');
        Route::post('/carrinho/compra', [CarrinhoController::class, 'compra'])->name('carrinho.compra');
        Route::get('/compras', [CompraController::class, 'index'])->name('compras.index');
        Route::get('/compras/{venda}', [CompraController::class, 'show'])->name('compras.show');
    });
});


// Rotas de Administrador
Route::prefix('admin')->name('admin.')->group(function () {


    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.index');
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


    // Rotas que precisam de autenticação do admin
    Route::middleware([RedirectIfNotAdmin::class])->group(function () {

        Route::get('/', [HomeAdminController::class, 'index'])->name('home');

        Route::resource('categorias', CategoriaController::class);
        Route::resource('produtos', ProdutoAdminController::class);
        Route::get('vendas', [VendaAdminController::class, 'index'])->name('vendas.index');
        Route::get('vendas/{venda}', [VendaAdminController::class, 'show'])->name('vendas.show');

        // rota de perfil do admin
        Route::get('perfil', [PerfilAdminController::class, 'index'])->name('perfil.index');
        Route::put('perfil/{admin}', [PerfilAdminController::class, 'update'])->name('perfil.update');
    });
});
