@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Prévia da Compra</h3>
        <div class="row">
            <div class="col-md-4">
                <div class="card" style="width: 15rem;">
                    <img src="{{ $produto->getFotoUrlAttribute() }}" class="card-img-top" alt="{{ $produto->nome }}">
                    <div class="card-body">
                        <h4 class="card-title">{{ $produto->nome }}</h4>
                        <h5 class="card-title">
                            <strong>R$ {{ number_format($produto->valor, 2, ',', '.') }}</strong>
                        </h5>
                        <p>Quantidade: {{ $quantidade }}</p>

                    </div>
                </div>
            </div>
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
                        <tr>
                            <td>{{ $produto->nome }}</td>
                            <td>{{ $quantidade }}</td>
                            <td>R$ {{ number_format($produto->valor, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($produto->valor * $quantidade, 2, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                <form action="{{ route('cliente.carrinho.compra')}}" method="post">
                    @csrf
                    <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                    <input type="hidden" name="quantidade" value="{{ $quantidade }}">
                    <input type="hidden" name="total" value="{{$produto->valor * $quantidade}}">
                    <button type="submit" class="btn btn-primary">Finalizar Compra</button>
                </form>
            </div>

        </div>
    </div>
@endsection

@section('styles')
    <style>
        .card-img-top {
            width: 100%;
            height: 200px;
            /* Reduzido para o tamanho desejado */
            object-fit: cover;
        }
    </style>
@endsection
