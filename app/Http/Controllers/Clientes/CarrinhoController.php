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
    // Exibe a página do carrinho
    public function index()
    {
        $carrinho = session()->get('carrinho', []);
        $total = 0;

        foreach ($carrinho as $produto) {
            $total += $produto['valor'] * $produto['quantidade'];
        }
        return view('cliente.carrinho.index', compact('carrinho', 'total'));
    }

    // Adiciona um produto ao carrinho
    public function adicionarAoCarrinho(Request $request)
    {
        $produtoId = $request->input('produto_id');
        $quantidade = $request->input('quantidade', 1);
        $quantidade = (int) $quantidade;

        $produto = Produto::find($produtoId);

        if ($produto->quantidade == 0) {
            return redirect()->back()->with('error', 'Este produto está esgotado e não pode ser adicionado ao carrinho.');
        }

        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$produtoId])) {
            $carrinho[$produtoId]['quantidade'] += $quantidade;
        } else {
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

    // Remove um produto do carrinho parcialmente ou totalmente
    public function atualizarCarrinho(Request $request, Produto $produto)
    {
        $quantidade = $request->input('quantidade', 1);
        $quantidade = (int) $quantidade;
        $action = $request->input('action', 'decrementar'); // Padrão: decrementar

        $carrinho = session()->get('carrinho', []);

        // Se a ação for decrementar retira 1 do carrinho, se for remover retira por completo do carrinho
        if (isset($carrinho[$produto->id])) {
            if ($action === 'remover' || $carrinho[$produto->id]['quantidade'] <= $quantidade) {
                unset($carrinho[$produto->id]);
            } else {
                $carrinho[$produto->id]['quantidade'] -= $quantidade;
            }
            session()->put('carrinho', $carrinho);
        } else {
            return redirect()->route('cliente.carrinho.index')->with('error', 'Produto não encontrado no carrinho!');
        }

        return redirect()->route('cliente.carrinho.index')->with('success', 'Carrinho atualizado com sucesso!');
    }


    // Finaliza a compra
    public function compra(VendaRequest $request)
    {
        $data = $request->validated();

        if (empty(session()->get('carrinho'))) {
            return redirect()->route('cliente.home')->with('error', 'Carrinho vazio, adicione produtos antes de finalizar a compra!');
        }
        foreach ($data['produtos'] as $produto) {
            $produtoModel = Produto::find($produto['id']);

            if ($produtoModel->quantidade < $produto['quantidade']) {
                session()->forget('carrinho');
                return redirect()->route('cliente.home')->with('error', 'Estoque insuficiente para o produto ' . $produtoModel->nome);
            }
        }
        DB::transaction(function () use ($data) {
            $venda = Venda::create([
                'total' => $data['total'],
                'user_id' => Auth::id(),
            ]);
            foreach ($data['produtos'] as $produto) {
                $produtoModel = Produto::find($produto['id']);
                $venda->produtos()->attach($produto['id'], ['quantidade' => $produto['quantidade'], 'valor_produto' => $produtoModel->valor]);
                $produtoModel->decrement('quantidade', $produto['quantidade']);
            }
            session()->forget('carrinho');
        });

        return redirect()->route('cliente.compras.index')->with('success', 'Compra realizada com sucesso!');
    }

    
}
