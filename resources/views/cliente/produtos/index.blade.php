@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-start">
            @foreach ($produtos as $produto)
                <div class="col-md-3 d-flex mb-4">
                    <form action="{{ route('cliente.carrinho.index') }}" id="compra-form" method="post">
                        <div class="card flex-fill" style="width: 18rem;">
                            <img src="{{ $produto->getFotoUrlAttribute() }}" class="card-img-top" alt="{{ $produto->nome }}">
                            <div class="card-body">
                                <h4 class="card-title">{{ $produto->nome }}</h4>
                                <h5 class="card-title">
                                    <strong>R$ {{ number_format($produto->valor, 2, ',', '.') }}</strong>
                                </h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <img src="{{ $produto->categoria->getIconeUrlAttribute() }}" alt="Icone"
                                        width="30" height="30">
                                    {{ $produto->categoria->nome }}
                                </li>
                                <li class="list-group-item">
                                    <div class="form-group">
                                        <label for="nome">Quantidade</label>
                                        <input type="number" class="form-control" name="quantidade"
                                        value="1" min="1" max="10">
                                    </div>
                                </li>
                            </ul>
                            <div class="card-body d-flex justify-content-around">
                                <a href="#" class="btn btn-secondary"><i class="fas fa-plus"></i> Carrinho</a>

                                <div class="form-container">

                                    @csrf
                                    <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i>
                                        Comprar</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .card-img-top {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
    </style>
@endsection

@section('scripts')

@endsection
