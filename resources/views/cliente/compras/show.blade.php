@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Detalhes da Compra</h3>

            <div class="row">
                <h4>Produtos comprados</h4>
                @foreach ($venda->produtos as $produto)
                    <div class="col-md-3">
                        <div class="card" style="width: 15rem;">
                        <img src="{{ $produto->getFotoUrlAttribute() }}" class="card-img-top" alt="{{ $produto->nome  }}">
                            <div class="card-body">
                                <h4 class="card-title">{{ $produto->nome}}</h4>
                                <h5 class="card-title">
                                    <strong>R$ {{ number_format($produto->valor , 2, ',', '.') }}</strong>
                                </h5>
                                <p>Quantidade: {{ $produto->pivot->quantidade }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row mt-4">
                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Valor Unitário</th>
                                <th>Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($venda->produtos as $produto)
                                <tr>
                                    <td>{{ $produto->nome }}</td>
                                    <td>{{ $produto->pivot->quantidade  }}</td>
                                    <td>R$ {{ number_format($produto->valor, 2, ',', '.') }}</td>
                                    <td>R$ {{ number_format($produto->valor * $produto->pivot->quantidade, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-start mt-4">
                    <a href="{{ route('cliente.compras.index') }}" class="btn btn-primary">Voltar</a>

                </div>
            </div>

    </div>
@endsection

@section('styles')
    <style>
        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
    </style>
@endsection
