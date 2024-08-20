@extends('layouts.template')
@section('content')
<!-- Início Conteúdo -->
<div class="card-body">
  <h4 class="text-center">Administrador</h4>
  <p class="login-box-msg">Redefinir senha</p>
  <form action="{{ route('admin.password.update') }}" method="post">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="input-group mb-3">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-envelope"></span>
        </div>
      </div>
      <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="E-mail" value="{{ $email ?? old('email') }}" required>
      @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="input-group mb-3">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-lock"></span>
        </div>
      </div>
      <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Senha" minlength="8" required>
      @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="input-group mb-3">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-lock"></span>
        </div>
      </div>
      <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Confirmar senha" minlength="8" required>
      @error('password_confirmation')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="row">
        <button type="submit" class="btn btn-primary btn-block">Alterar senha</button>
    </div>
  </form>
</div>
<!-- Fim Conteúdo -->
@endsection
