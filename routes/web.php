<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('categoria', [CategoriaController::class, 'index'])->name('categoria.index');
    Route::get('categoria/create', [CategoriaController::class, 'create'])->name('categoria.create');
    Route::post('categoria', [CategoriaController::class, 'store'])->name('categoria.store');
    Route::get('categoria/{categoria}', [CategoriaController::class, 'show'])->name('categoria.show');
    Route::get('categoria/{categoria}/edit', [CategoriaController::class, 'edit'])->name('categoria.edit');
    Route::put('categoria/{categoria}', [CategoriaController::class, 'update'])->name('categoria.update');
    Route::delete('categoria/{categoria}', [CategoriaController::class, 'destroy'])->name('categoria.destroy');

});
