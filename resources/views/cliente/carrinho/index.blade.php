@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-5">Carrinho de Compras</h2>

        @if (!$carrinho)
            <div class="alert alert-warning" role="alert">
                Seu carrinho está vazio!
            </div>
        @else
            <div class="d-flex mt-5">
                <div class="bg-white rounded p-3 col-md-8">
                    @foreach ($carrinho as $key => $item)
                        <div class="row mb-3 align-items-center border-bottom p-3">
                            <div class="col-md-2 d-flex align-items-center">
                                <img src="{{ $item['foto'] }}" class="img-fluid rounded" alt="{{ $item['nome'] }}"
                                    width="100" height="100">
                            </div>
                            <div class="col-md-4">
                                <h4 class="card-title mb-1">{{ $item['nome'] }}</h4>
                                <h5 class="card-title">
                                    <strong>R$ {{ number_format($item['valor'], 2, ',', '.') }}</strong>
                                </h5>
                            </div>
                            <div class="col-md-3 d-flex align-items-center justify-content-around">


                                {{-- decrementa --}}
                                <form action="{{ route('cliente.carrinho.limpar') }}" method="post" class="d-flex align-items-center">
                                    @csrf
                                    <input type="hidden" name="produto_id" value="{{ $key }}">
                                    <input type="hidden" name="valor" value="{{ $item['valor'] }}">
                                    <input type="hidden" name="quantidade" value="1">
                                    <button type="submit" value="adicionar"class="btn btn-primary ms-2"><i class="fas fa-minus"></i></button>
                                </form>

                                <div>{{$item['quantidade']}}</div>

                                {{-- imcrementa --}}
                                <form action="{{ route('cliente.carrinho.adicionar') }}" method="post" class="d-flex align-items-center">
                                    @csrf
                                    <input type="hidden" name="produto_id" value="{{ $key }}">
                                    <input type="hidden" name="valor" value="{{ $item['valor'] }}">
                                    <input type="hidden" name="quantidade" value="1">
                                    <button type="submit" value="decrementar"class="btn btn-primary ms-2"><i class="fas fa-plus"></i></button>
                                </form>
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                <form action="{{ route('cliente.carrinho.remover', $key) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
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
                            <form action="{{ route('cliente.carrinho.compra') }}" method="post">
                                @csrf
                                @foreach ($carrinho as $produtoId => $produto)
                                    <input type="hidden" name="produtos[{{ $produtoId }}][id]" value="{{ $produtoId }}">
                                    <input type="hidden" name="produtos[{{ $produtoId }}][quantidade]" value="{{ $produto['quantidade'] }}">
                                    <input type="hidden" name="produtos[{{ $produtoId }}][valor]" value="{{ $produto['valor'] }}">
                                @endforeach
                                <input type="hidden" name="total" value="{{ $total }}">
                                <h5>Total: <strong>R$ {{ number_format($total, 2, ',', '.') }} </strong></h5>
                                <button type="submit" class="btn btn-primary mt-4">Finalizar Compra</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        function updateQuantity(produtoId, change) {
            const input = document.getElementById(`quantidade-${produtoId}`);
            const currentQuantity = parseInt(input.value);
            const newQuantity = Math.max(1, currentQuantity + change);
            input.value = newQuantity;
        }
    </script>
@endsection
