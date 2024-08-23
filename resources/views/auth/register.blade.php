@extends('layouts.app')

@section('content')
    <div class="container min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <div class="text-center mb-4">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="logo" style="width: 200px;">
            </a>
        </div>

        <div class="card shadow-lg border-0 rounded-lg p-4" style="width: 100%; max-width: 450px;">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-primary">Registrar</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">Confirmar Senha</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a class="btn btn-link text-start" href="{{ route('login') }}">
                            Já tem uma conta? Faça login!
                        </a>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Registar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .btn.btn-link{
        text-decoration: none;
    }
    .btn.btn-link:hover{
        font-weight: bold;
    }
</style>
@endsection
