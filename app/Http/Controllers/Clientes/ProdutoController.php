<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::orderBy('nome')->get();
        $produtos = Produto::orderBy('nome')->get();
        return view('cliente.produtos.index', compact('produtos','categorias'));
    }
}
