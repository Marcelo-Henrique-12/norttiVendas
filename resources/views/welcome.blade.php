@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: calc(100vh - 200px);">
            <div class="col-md-8 d-flex justify-content-center flex-column align-items-center">

                <img src="{{ asset('images/logo.png') }}" alt="Nortti Logo" width="400px">
                <h2 class="text-center text-dark mt-3">Bem-vindo ao <span class="text-primary">Nortti Vendas</span></h2>
                <div class="d-flex justify-content-center mt-4 gap-3 w-100">
                    <a href="{{ route('login') }}" class="btn btn-secondary btn-lg w-50">Login como Cliente</a>
                    <a href="{{ route('admin.login') }}" class="btn btn-primary btn-lg w-50">Login como Administrador</a>
                </div>
            </div>
        </div>
    </div>

@endsection
