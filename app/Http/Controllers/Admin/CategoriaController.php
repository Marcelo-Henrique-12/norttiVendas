<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categorias = Categoria::search($request)->orderBy('nome')->paginate()->withQueryString();
        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriaRequest $request)
    {
        $data = $request->validated();
        DB::transaction(function () use ($data, $request) {
            $categoria = Categoria::create($data);

            if ($request->icone) {
                $categoria->icone = $request->file('icone')->store('icones/' . $categoria->id);
                $categoria->save();
            }
        });
        return redirect()->route('admin.categorias.index')->with('success', 'Categoria criada com sucesso!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        return view('admin.categorias.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriaRequest $request, Categoria $categoria)
    {
        $data = $request->validated();
        DB::transaction(function () use ($data, $request, $categoria) {
            $categoria->update($data);

            if ($request->icone) {
                Storage::delete($categoria->icone);
                $categoria->icone = $request->file('icone')->store('icones/' . $categoria->id);
                $categoria->save();
            }
        });
        return redirect()->route('admin.categorias.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        DB::transaction(function () use ($categoria) {
            Storage::delete($categoria->icone);
            $categoria->delete();
        });
        return redirect()->route('admin.categorias.index')->with('success', 'Categoria deletada com sucesso!');
    }
}
