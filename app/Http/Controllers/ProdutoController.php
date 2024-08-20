<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutodRequest;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
   
        $categorias = Categoria::orderBy('nome')->get();
        $produtos = Produto::search($request)->orderBy('nome')->paginate()->withQueryString();
        return view('admin.produtos.index', compact('produtos','categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::orderBy('nome')->get();
        return view('admin.produtos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdutodRequest $request)
    {
        $data = $request->validated();
        DB::transaction(function () use ($data, $request) {
            $produto = Produto::create($data);

            if ($request->foto) {
                $produto->foto = $request->file('foto')->store('produtosFotos/' . $produto->id);
                $produto->save();
            }
        });
        return redirect()->route('admin.produtos.index')->with('success', 'Produto criado com sucesso!');;
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        return view('admin.produtos.show', compact('produto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('admin.produtos.edit', compact('produto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdutodRequest $request, Produto $produto)
    {
        $data = $request->validated();
        DB::transaction(function () use ($data, $request, $produto) {
            $produto->update($data);

            if ($request->icone) {
                Storage::delete($produto->foto);
                $produto->foto = $request->file('foto')->store('produtosFotos/' . $produto->id);
                $produto->save();
            }
        });
        return redirect()->route('admin.produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto) {

        DB::transaction(function () use ($produto) {
            Storage::delete($produto->foto);
            $produto->delete();
        });
        return redirect()->route('admin.produtos.index')->with('success', 'Produto deletado com sucesso!');
    }
}
