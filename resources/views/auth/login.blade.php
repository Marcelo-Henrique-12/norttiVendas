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
                <h3 class="fw-bold text-primary">{{ __('Login') }}</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3 mt-5">
                        <label for="password" class="form-label">Senha</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between flex-column justify-content-start mb-3 mt-5">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Lembrar-me
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="btn btn-link text-start mt-3" href="{{ route('password.request') }}">
                                Esqueceu a senha?
                            </a>
                        @endif

                        <a class="btn btn-link text-start mt-1" href="{{ route('register') }}">
                            Novo Acesso? Registre-se!
                        </a>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Login') }}
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
