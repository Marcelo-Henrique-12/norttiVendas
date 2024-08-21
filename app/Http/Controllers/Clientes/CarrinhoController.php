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


    public function exibirCarrinho()
{
    $carrinho = session()->get('carrinho', []);
    $total = 0;

    foreach ($carrinho as $produto) {
        $total += $produto['valor'] * $produto['quantidade'];
    }

    return view('cliente.carrinho.index', compact('carrinho', 'total'));
}



    public function compra(VendaRequest $request)
    {
    
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $venda = Venda::create([
                'total' => $data['total'],
                'user_id' => Auth::id(),
            ]);

            foreach ($data['produtos'] as $produto) {
                $venda->produtos()->attach($produto['id'], ['quantidade' => $produto['quantidade']]);
            }

            // Limpar o carrinho após a compra
            session()->forget('carrinho');
        });

        return redirect()->route('cliente.home')->with('success', 'Compra realizada com sucesso!');
    }


    public function adicionarAoCarrinho(Request $request)
    {
        $produtoId = $request->input('produto_id');
        $quantidade = $request->input('quantidade', 1);
        $quantidade = (int) $quantidade;

        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$produtoId])) {
            $carrinho[$produtoId]['quantidade'] += $quantidade;
        } else {
            $produto = Produto::find($produtoId);
            $carrinho[$produtoId] = [
                'nome' => $produto->nome,
                'quantidade' => $quantidade,
                'valor' => $produto->valor,
                'foto' => $produto->getFotoUrlAttribute()
            ];
        }

        session()->put('carrinho', $carrinho);

        if ($request->input('action') === 'comprar') {
            return redirect()->route('cliente.carrinho.index')->with('success', 'Produto adicionado ao carrinho e pronto para finalizar a compra!');
        }

        return redirect()->back()->with('success', 'Produto adicionado ao carrinho!');
    }


    public function remover($produtoId)
    {
        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$produtoId])) {
            unset($carrinho[$produtoId]);
            session()->put('carrinho', $carrinho);
        }

        return redirect()->route('cliente.carrinho.index')->with('success', 'Produto removido do carrinho!');
    }

    public function limpar()
    {
        session()->forget('carrinho');

        return redirect()->route('cliente.carrinho.index')->with('success', 'Carrinho limpo com sucesso!');
    }

}
