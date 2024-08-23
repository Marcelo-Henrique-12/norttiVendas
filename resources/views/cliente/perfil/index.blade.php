@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-5">
            <h2 class="mb-5 mt-5"><i class="fas fa-user"></i> Editar Perfil </h2>
            <form method="POST" action="{{ route('cliente.perfil.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group mb-4">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nome"
                        value="{{ $user->name }}">
                    @error('name')
                        <div class="text-danger fw-bold">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email"
                        value="{{ $user->email }}">
                    @error('email')
                        <div class="text-danger fw-bold">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" id="senha" name="password" class="form-control" placeholder="Senha">
                    @error('password')
                      <div class="text-danger fw-bold">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="password-confirm" class="form-label">Confirmar Senha</label>
                    <input type="password" id="password-confirm" name="password_confirmation" class="form-control"
                        placeholder="Confirmar Senha">
                    @error('password_confirmation')
                        <div class="text-danger fw-bold">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ route('cliente.home') }}" class="btn btn-outline-primary me-2">Voltar</a>

                <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
            </form>
        </div>
    </div>
@endsection
