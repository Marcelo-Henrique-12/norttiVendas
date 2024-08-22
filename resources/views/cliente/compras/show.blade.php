@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-5">Detalhes da Compra</h2>

        <div class="d-flex mt-5">
            <div class="bg-white rounded p-3 col-md-8">
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

            <div class="bg-white rounded p-3 col-md-4 ms-md-3">
                <div class="row mb-3">
                    <div class="col-12">
                        <h3>Resumo</h3>
                    </div>
                    <div class="col-12">
                        <h5>Total: <strong>R$ {{ number_format($venda->total, 2, ',', '.') }} </strong></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
