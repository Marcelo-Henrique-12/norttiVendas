@extends('adminlte::page')

@section('title', 'Detalhes da Compra')

@section('content_header')
    <h1>Detalhes da Compra</h1>
@stop

@section('content')
    <div class="card card-secondary card-outline">

        <div class="card-body">
            <div class="d-flex flex-column">

                <div class="p-3 col-md-4 ms-md-3">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h3>Total: <strong>R$ {{ number_format($venda->total, 2, ',', '.') }} </strong></h3>
                        </div>
                    </div>
                </div>

                <div class="p-3 col-md-8">
                    <h4>Produtos Comprados:</h4>
                    @foreach ($venda->produtos as $produto)
                        <div class="row mb-3 align-items-center border-bottom p-3">
                            <div class="col-md-2 d-flex align-items-center">
                                <img src="{{ $produto->getFotoUrlAttribute() }}" class="img-fluid rounded"
                                    alt="{{ $produto->nome }}" width="100" height="100">
                            </div>
                            <div class="col-md-4">
                                <h4 class="card-title mb-1">{{ $produto->nome }}</h4>
                                <h5 class="card-title">
                                    <strong>R$ {{ number_format($produto->valor, 2, ',', '.') }}</strong>
                                </h5>
                            </div>
                            <div class="col-md-3 d-flex align-items-center justify-content-around">
                                <div>Quantidade comprada: {{ $produto->pivot->quantidade }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.vendas.index') }}" type="button" class="btn btn-secondary">Voltar</a>
                </div>
            </div>
        </div>
    </div>
@stop
