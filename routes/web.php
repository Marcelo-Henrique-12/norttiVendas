<?php

use App\Http\Controllers\AuthAdmin\ForgotPasswordController;
use App\Http\Controllers\AuthAdmin\LoginController;
use App\Http\Controllers\AuthAdmin\ResetPasswordController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\HomeAdminController;
use App\Http\Controllers\Admin\ProdutoAdminController;
use App\Http\Controllers\Clientes\CarrinhoController;
use App\Http\Controllers\Clientes\HomeController;
use App\Http\Controllers\Clientes\ProdutoController;

use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();


// Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Rotas de Cliente
Route::middleware(['auth', Authenticate::class])->name('cliente.')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');

    Route::post('/carrinho/compra', [CarrinhoController::class, 'compra'])->name('carrinho.compra');
    Route::post('/carrinho', [CarrinhoController::class, 'index'])->name('carrinho.index');
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


    // Rotas protegidas para o admin
    Route::middleware(['auth:admin', Authenticate::class])->group(function () {
        Route::get('/', [HomeAdminController::class, 'index'])->name('home');

        // Rotas de categorias

        Route::resource('categorias', CategoriaController::class);

        // Rotas de produtos

        Route::resource('produtos', ProdutoAdminController::class);
    });
});
