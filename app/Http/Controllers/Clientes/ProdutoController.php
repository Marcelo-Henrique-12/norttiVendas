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
        $carrinho = session()->get('carrinho', []);

        $quantidadeCarrinho = [];
        foreach ($carrinho as $produtoId => $item) {
            $quantidadeCarrinho[$produtoId] = $item['quantidade'];
        }
        $produtos = Produto::search($request)->orderBy('nome')->paginate(20)->withQueryString();

        return view('cliente.produtos.index', compact('categorias', 'produtos', 'quantidadeCarrinho'));
    }

}
