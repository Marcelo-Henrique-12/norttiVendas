@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="mb-5">
            <h2 class="mb-5">Produtos</h2>
            <form class="d-flex flex-column flex-md-row align-items-end" method="GET"
                action="{{ route('cliente.produtos.index') }}">

                <div class="col-sm-2 form-group mb-3 mb-md-0 me-md-3">
                    <label for="categoria" class="form-label">Categoria</label>
                    <select id="categoria" name="categoria_id" class="form-select">
                        <option value="">Selecione uma categoria</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}"
                                {{ (int) old('categoria_id', request()->categoria_id) === $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-4 form-group mb-3 mb-md-0 me-md-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" id="nome" name="nome" class="form-control" placeholder="Nome do produto"
                        value="{{ request()->nome ?? '' }}">
                </div>

                <div class="col-sm-3 form-group mb-3 mb-md-0 me-md-3">
                    <label for="ordenar" class="form-label">Ordenar por</label>
                    <select id="ordenar" name="ordenar" class="form-select">
                        <option value="">Selecione</option>
                        <option value="preco_crescente"
                            {{ old('ordenar', request()->ordenar) === 'preco_crescente' ? 'selected' : '' }}>Menor
                            preço</option>
                        <option value="preco_decrescente"
                            {{ old('ordenar', request()->ordenar) === 'preco_decrescente' ? 'selected' : '' }}>
                            Maior preço</option>
                    </select>
                </div>

                <a href="{{ route('cliente.produtos.index') }}" class="btn btn-primary me-2">Limpar campos</a>
                <button class="btn btn-outline-primary" type="submit">Pesquisar</button>

            </form>


        </div>

        <div class="row justify-content-start mt-5">
            @foreach ($produtos as $produto)
                @php
                    $quantidadeNoCarrinho = $quantidadeCarrinho[$produto->id] ?? 0;
                    $quantidadeDisponivel = $produto->quantidade - $quantidadeNoCarrinho;
                @endphp
                <div class="col-md-6 col-lg-4 col-xl-3 d-flex mb-4">
                    <div class="card flex-fill position-relative rounded border-0 shadow-sm hover-shadow"
                        style="width: 100%;">
                        @if ($quantidadeDisponivel <= 0)
                            <div class="position-absolute top-0 start-0 bg-danger text-white p-2" style="z-index: 1;">
                                <i class="fas fa-lock"></i> Esgotado
                            </div>
                        @endif
                        <img src="{{ $produto->getFotoUrlAttribute() }}" class="card-img-top rounded"
                            alt="{{ $produto->nome }}">

                        <div class="card-body d-flex flex-column">
                            <p class="card-title fs-5">{{ $produto->nome }}</p>
                            <p class="card-title fs-5">
                                <img src="{{ $produto->categoria->getIconeUrlAttribute() }}" alt="Icone" width="20"
                                    height="20">
                                {{ $produto->categoria->nome }}
                            </p>
                            <p class="card-title fs-4"><strong>R$
                                    {{ number_format($produto->valor, 2, ',', '.') }}</strong>
                            </p>

                            <div class="mt-auto">
                                <form action="{{ route('cliente.carrinho.adicionar') }}" method="post"
                                    class="d-flex justify-content-between">
                                    @csrf
                                    <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                                    <input type="hidden" name="quantidade" value="1">
                                    <button type="submit" name="action" value="carrinho"
                                        class="btn btn-secondary btn-sm flex-fill me-1"
                                        {{ $quantidadeDisponivel <= 0 ? 'disabled' : '' }}>
                                        <i class="fa-solid fa-cart-shopping"></i> Carrinho
                                    </button>
                                    <button type="submit" name="action" value="comprar"
                                        class="btn btn-primary btn-sm flex-fill"
                                        {{ $quantidadeDisponivel <= 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-plus"></i> Comprar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.form-group input[type="number"]').forEach(input => {
                input.addEventListener('input', function() {
                    const quantidade = this.value;
                    const forms = this.closest('.card').querySelectorAll('form');
                    forms.forEach(form => {
                        form.querySelector('input[name="quantidade"]').value = quantidade;
                    });
                });
            });
        });
    </script>
@endsection
