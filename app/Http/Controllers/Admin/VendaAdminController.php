<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Http\Request;

class VendaAdminController extends Controller
{
    public function index(Request $request)
    {

        $vendas = Venda::search($request)->orderBy('created_at', 'desc')->paginate()->withQueryString();
        $produtosVendidos = $vendas->flatMap(function ($venda) {
            return $venda->produtos;
        })->unique('id');
        $categorias = Categoria::whereIn('id', $produtosVendidos->pluck('categoria_id'))->get();


        return view('admin.vendas.index', compact('vendas','categorias', 'produtosVendidos'));
    }

    public function show(Venda $venda)
    {
        return view('admin.vendas.show', compact('venda'));
    }
}
