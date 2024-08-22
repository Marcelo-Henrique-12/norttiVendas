<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompraController extends Controller
{
    public function index(){

        $compras = Auth::user()->vendas;

        return view('cliente.compras.index', compact('compras'));
    }


    public function show(Venda $venda)
    {
        return view('cliente.compras.show', compact('venda'));
    }
}
