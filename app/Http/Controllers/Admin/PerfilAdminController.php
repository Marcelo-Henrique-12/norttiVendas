<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.perfil.index', compact('admin'));
    }


    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $loggedUser = Auth::guard('admin')->user();

        if ($admin->id != $loggedUser->id) {
            return redirect()->route('admin.perfil.index')->with('error', 'Não Autorizado!');
        }
        $dados = $request->validated();

        if (isset($dados['password'])) {
            $dados['password'] = Hash::make($dados['password']);
        } else {
            unset($dados['password']);
        }

        unset($dados['password_confirmation']);
        $admin->update($dados);

        return redirect()->route('admin.perfil.index')->with('success', 'Perfil atualizado com sucesso!');
    }
}
