@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Prévia da Compra</h3>

        @if (!$carrinho)
            <div class="alert alert-warning" role="alert">
                Seu carrinho está vazio!
            </div>
        @else
            <div class="row">
                @foreach ($carrinho as $item)
                    <div class="col-md-3">
                        <div class="card" style="width: 15rem;">
                            <img src="{{ $item['foto'] }}" class="card-img-top" alt="{{ $item['nome']  }}">
                            <div class="card-body">
                                <h4 class="card-title">{{ $item['nome'] }}</h4>
                                <h5 class="card-title">
                                    <strong>R$ {{ number_format($item['valor'] , 2, ',', '.') }}</strong>
                                </h5>
                                <p>Quantidade: {{ $item['quantidade']  }}</p>
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
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($carrinho as $key =>  $item)
                                <tr>
                                    <td>{{ $item['nome'] }}</td>
                                    <td>{{ $item['quantidade']  }}</td>
                                    <td>R$ {{ number_format($item['valor'], 2, ',', '.') }}</td>
                                    <td>R$ {{ number_format($item['valor'] * $item['quantidade'], 2, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cliente.carrinho.remover', $key) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <form action="{{ route('cliente.carrinho.compra') }}" method="post">
                        @csrf
                        @foreach ($carrinho as $produtoId => $produto)
                            <input type="hidden" name="produtos[{{ $produtoId }}][id]" value="{{ $produtoId }}">
                            <input type="hidden" name="produtos[{{ $produtoId }}][quantidade]" value="{{ $produto['quantidade'] }}">
                            <input type="hidden" name="produtos[{{ $produtoId }}][valor]" value="{{ $produto['valor'] }}">
                        @endforeach
                        <input type="hidden" name="total" value="{{ $total }}">
                        <div class="alert alert-success" role="alert">
                            Total: {{{ $total }}}
                        </div>
                        <button type="submit" class="btn btn-primary">Finalizar Compra</button>
                    </form>
                </div>
            </div>
        @endif
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
