<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendaRequest;
use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarrinhoController extends Controller
{
    public function index(Request $request)
    {

        $produto_id = $request->input('produto_id');
        $quantidade = $request->input('quantidade');

        $produto = Produto::find($produto_id);

        return view('cliente.carrinho.index', compact('produto', 'quantidade'));
    }

    public function compra(VendaRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $request) {
            $venda = Venda::create([
                'total' => $data['total'],
                'user_id' => Auth::id()
            ]);

            $venda->produtos()->attach($data['produto_id'], ['quantidade' => $data['quantidade']]);
            // foreach ($data['produtos'] as $produto) {
            //     $venda->produtos()->attach($produto['id'], ['quantidade' => $produto['quantidade']]);
            // }
        });

        return redirect()->route('cliente.home')->with('success', 'Compra realizada com sucesso!');
    }
}
