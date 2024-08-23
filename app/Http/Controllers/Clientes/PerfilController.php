<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePerfilRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('cliente.perfil.index', compact('user'));
    }

    public function update(UpdatePerfilRequest $request, User $user)
    {
        $loggedUser = Auth::user();

        if ($user->id != $loggedUser->id) {
            return redirect()->route('cliente.perfil.index')->with('error', 'Não Autorizado!');
        }

        $dados = $request->validated();

        if (isset($dados['password'])) {
            $dados['password'] = Hash::make($dados['password']);
        } else {
            unset($dados['password']);
        }

        unset($dados['password_confirmation']);
        $user->update($dados);

        return redirect()->route('cliente.perfil.index')->with('success', 'Perfil atualizado com sucesso!');
    }
}
