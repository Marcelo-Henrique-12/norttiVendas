@extends('layouts.app')

@section('content')
    @if (!$produtos->count())
        <div class="container">
            <div class="alert alert-warning" role="alert">
                Nenhum produto encontrado.
            </div>
        </div>
    @else
        <div class="container">
            <div class="mb-5">
                <h2 class="mb-5 mt-5"><i class="fas fa-box"></i> Produtos</h2>
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
                        <input type="text" id="nome" name="nome" class="form-control"
                            placeholder="Nome do produto" value="{{ request()->nome ?? '' }}">
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

                    <a href="{{ route('cliente.produtos.index') }}" class="btn btn-outline-primary me-2">Limpar campos</a>
                    <button class="btn btn-primary" type="submit">Pesquisar</button>

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
                                    <img src="{{ $produto->categoria->getIconeUrlAttribute() }}" alt="Icone"
                                        width="20" height="20">
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
            @if ($produtos->hasPages())
                <div class="card-footer">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            {{-- Link para a página anterior --}}
                            @if ($produtos->onFirstPage())
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Anterior</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $produtos->previousPageUrl() }}"
                                        tabindex="-1">Anterior</a>
                                </li>
                            @endif

                            {{-- Primeiro link --}}
                            @if ($produtos->currentPage() > 3)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $produtos->url(1) }}">1</a>
                                </li>
                                @if ($produtos->currentPage() > 4)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                            @endif

                            {{-- Links das páginas vizinhas --}}
                            @for ($i = max($produtos->currentPage() - 2, 1); $i <= min($produtos->currentPage() + 2, $produtos->lastPage()); $i++)
                                <li class="page-item {{ $i == $produtos->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $produtos->url($i) }}">{{ $i }}
                                        @if ($i == $produtos->currentPage())
                                            <span class="sr-only">(current)</span>
                                        @endif
                                    </a>
                                </li>
                            @endfor

                            {{-- Último link --}}
                            @if ($produtos->currentPage() < $produtos->lastPage() - 2)
                                @if ($produtos->currentPage() < $produtos->lastPage() - 3)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $produtos->url($produtos->lastPage()) }}">{{ $produtos->lastPage() }}</a>
                                </li>
                            @endif

                            {{-- Link para a próxima página --}}
                            @if ($produtos->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $produtos->nextPageUrl() }}">Próxima</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <a class="page-link" href="#">Próxima</a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif
    @endif
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
