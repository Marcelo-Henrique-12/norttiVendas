@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
    <h1>Editar Perfil</h1>
@stop

@section('content')
    <div class="card card-secondary card-outline">
        <form action="{{ route('admin.perfil.update',$admin->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                <div class="row">
                    <div class="col-xl-4 form-group">
                        <label for="nome_completo">Nome<abbr title="Campo Obrigatório" class="text-danger">*</abbr></label>
                        <input type="text" class="form-control @error('nome_completo') is-invalid @enderror" name="nome_completo"
                            placeholder="Nome" value="{{ old('nome_completo',$admin->nome_completo) ?? '' }}">
                        @error('nome_completo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- email e senha e confirmar senha --}}
                <div class="row">
                    <div class="col-xl-4 form-group">
                        <label for="email">E-mail<abbr title="Campo Obrigatório" class="text-danger">*</abbr></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            placeholder="E-mail" value="{{ old('email',$admin->email) ?? '' }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 form-group">
                        <label for="password">Senha<abbr title="Campo Obrigatório" class="text-danger">*</abbr></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            placeholder="Senha" value="{{ old('password') ?? '' }}">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 form-group">
                        <label for="password_confirmation">Confirmar Senha<abbr title="Campo Obrigatório"
                                class="text-danger">*</abbr></label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" placeholder="Confirmar Senha"
                            value="{{ old('password_confirmation') ?? '' }}">
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="card-footer">
                    <a href="{{ route('admin.perfil.index') }}" type="button" class="btn btn-secondary">Voltar</a>
                    <button type="submit" class="btn btn-success">Atualizar</button>
                </div>

        </form>
    </div>
@stop



