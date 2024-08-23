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
                <h3 class="fw-bold text-primary">Recuperar Senha</h3>
            </div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail Cadastrado</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Enviar Link de Recuperação
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
