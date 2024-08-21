@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-start">
            @foreach($produtos as $produto)
                <div class="col-md-4 d-flex mb-4">
                    <div class="card flex-fill" style="width: 18rem;">
                        <img src="{{ $produto->getFotoUrlAttribute() }}" class="card-img-top" alt="{{ $produto->nome }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $produto->nome }}</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <img src="{{ $produto->categoria->getIconeUrlAttribute() }}" alt="Icone" width="30" height="30">
                                {{ $produto->categoria->nome }}
                            </li>
                            <li class="list-group-item">
                                <p class="card-text">{{ $produto->categoria->descricao }}</p>
                            </li>
                        </ul>
                        <div class="card-body">
                            <a href="#" class="btn btn-secondary"><i class="fas fa-plus"></i> Carrinho</a>
                            <a href="#" class="btn btn-primary">Comprar</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
