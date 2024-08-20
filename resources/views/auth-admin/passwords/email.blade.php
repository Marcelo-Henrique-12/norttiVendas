@extends('layouts.template')
@section('content')
<!-- Início Conteúdo -->
<div class="card-body">
  <h4 class="text-center">Administrador</h4>
  <p class="login-box-msg">Informe abaixo o seu e-mail para receber um link para redefinir a sua senha de acesso.</p>
  <form action="{{ route('admin.password.email') }}" method="post">
    @csrf
    <div class="input-group mb-3">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-envelope"></span>
        </div>
      </div>
      <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" placeholder="E-mail" required>
      @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="row">
        <button type="submit" class="btn btn-primary btn-block">Solicitar nova senha</button>
        <a href="{{ route('admin.login') }}" type="button" class="btn btn-light btn-block">Tela inicial</a>
    </div>
  </form>
</div>
<!-- Fim Conteúdo -->
@endsection
