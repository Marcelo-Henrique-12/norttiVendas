<?php

use App\Http\Controllers\AuthAdmin\ForgotPasswordController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthAdmin\LoginController;
use App\Http\Controllers\AuthAdmin\ResetPasswordController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('admin')->name('admin.')->group(function () {


    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.index');
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


    // Rotas protegidas para o admin
    Route::middleware('auth:admin')->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        // Rotas de categorias

        Route::resource('categorias', CategoriaController::class);

        // Rotas de produtos

        Route::resource('produtos', ProdutoController::class);
    });
});
