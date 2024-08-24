@extends('layouts.app')

@section('content')
    <div class="container">
        @if (!$categorias->count())
            <div class="container">
                <div class="alert alert-warning" role="alert">
                    Nenhuma categoria encontrada.
                </div>
            </div>
        @else
            <h2 class="mt-5"><i class="fa-solid fa-tags"></i> Compre por Categorias</h2>

            <div class="row justify-content-start mt-5">
                @foreach ($categorias as $categoria)
                    <div class="col-md-4 col-lg-3 col-xl-2 d-flex mb-4">
                        <a href="{{ route('cliente.produtos.index', ['categoria_id' => $categoria->id]) }}"
                            class="categoria-link">
                            <div class="card flex-fill position-relative border-0 text-center">
                                <div class="card-body">
                                    <img src="{{ $categoria->getIconeUrlAttribute() }}"
                                        class="card-img-top rounded-circle mx-auto d-block" alt="{{ $categoria->nome }}">
                                    <p class="card-title fs-6 mt-1">{{ $categoria->nome }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            @if ($categorias->hasPages())
                <div class="card-footer">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            {{-- Link para a página anterior --}}
                            @if ($categorias->onFirstPage())
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Anterior</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $categorias->previousPageUrl() }}"
                                        tabindex="-1">Anterior</a>
                                </li>
                            @endif

                            {{-- Primeiro link --}}
                            @if ($categorias->currentPage() > 3)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $categorias->url(1) }}">1</a>
                                </li>
                                @if ($categorias->currentPage() > 4)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                            @endif

                            {{-- Links das páginas vizinhas --}}
                            @for ($i = max($categorias->currentPage() - 2, 1); $i <= min($categorias->currentPage() + 2, $categorias->lastPage()); $i++)
                                <li class="page-item {{ $i == $categorias->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $categorias->url($i) }}">{{ $i }}
                                        @if ($i == $categorias->currentPage())
                                            <span class="sr-only">(current)</span>
                                        @endif
                                    </a>
                                </li>
                            @endfor

                            {{-- Último link --}}
                            @if ($categorias->currentPage() < $categorias->lastPage() - 2)
                                @if ($categorias->currentPage() < $categorias->lastPage() - 3)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $categorias->url($categorias->lastPage()) }}">{{ $categorias->lastPage() }}</a>
                                </li>
                            @endif

                            {{-- Link para a próxima página --}}
                            @if ($categorias->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $categorias->nextPageUrl() }}">Próxima</a>
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
        .card {
            width: 100%;
            transition: box-shadow 0.3s;
        }

        .card:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .card-title {
            font-size: 0.9rem;
        }


        .categoria-link {
            text-decoration: none;
            color: inherit;
        }

        .categoria-link:hover {
            color: inherit;
        }
    </style>
@endsection
