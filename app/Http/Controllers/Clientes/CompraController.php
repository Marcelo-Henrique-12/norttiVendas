<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompraController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $compras = Venda::where('user_id', $user->id)
            ->with('produtos')
            ->search($request)
            ->orderBy('created_at', 'desc')
            ->get();
        $produtosComprados = $compras->flatMap(function ($compra) {
            return $compra->produtos;
        })->unique('id');

        return view('cliente.compras.index', compact('compras', 'produtosComprados'));
    }

    public function show(Venda $venda)
    {
        return view('cliente.compras.show', compact('venda'));
    }
}
