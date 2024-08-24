<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('nome')->paginate(20)->withQueryString();
        return view('cliente.home', compact('categorias'));
    }
}
