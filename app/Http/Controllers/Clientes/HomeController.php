<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('cliente.home');
    }
}
