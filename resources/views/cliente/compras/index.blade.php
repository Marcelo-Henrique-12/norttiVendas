@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-5"><i class="fa-solid fa-bag-shopping"></i> Compras Realizadas</h2>

        @if (!$compras)
            <div class="alert alert-warning" role="alert">
                Sem compras realizadas!
            </div>
        @else
            <div class="mb-5 mt-5">
                <form class="d-flex flex-column flex-md-row align-items-end" method="GET"
                    action="{{ route('cliente.compras.index') }}">

                    <div class="col-sm-2 form-group mb-3 mb-md-0 me-md-3">
                        <label for="produto" class="form-label">Produto</label>
                        <select id="produto" name="produto_id" class="form-select">
                            <option value="">Selecione um Produto</option>
                            @foreach ($produtosComprados as $produto)
                                <option value="{{ $produto->id }}"
                                    {{ (int) old('produto_id', request()->produto_id) === $produto->id ? 'selected' : '' }}>
                                    {{ $produto->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-4 form-group mb-3 mb-md-0 me-md-3">
                        <label for="data" class="form-label">Data</label>
                        <input type="date" id="data" name="data" class="form-control"
                            placeholder="Nome do produto" value="{{ request()->data ?? '' }}">
                    </div>


                    <div class="col-sm-3 form-group mb-3 mb-md-0 me-md-3">
                        <label for="ordenar" class="form-label">Ordenar por</label>
                        <select id="ordenar" name="ordenar" class="form-select">
                            <option value="">Selecione</option>
                            <option value="data_crescente"
                                {{ old('ordenar', request()->ordenar) === 'data_crescente' ? 'selected' : '' }}>Mais
                                recentes</option>
                            <option value="data_decrescente"
                                {{ old('ordenar', request()->ordenar) === 'data_decrescente' ? 'data_decrescente' : '' }}>
                                Mais antigos</option>
                        </select>
                    </div>

                    <a href="{{ route('cliente.compras.index') }}" class="btn btn-outline-primary me-2">Limpar campos</a>
                    <button class="btn btn-primary" type="submit">Pesquisar</button>

                </form>


            </div>
            <div class="row mt-4">

                <div class="card-body table-responsive p-0">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Data</th>
                                <th>Valor Total</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($compras as $compra)
                                <tr>
                                    <td>{{ $compra->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>R$ {{ number_format($compra->total, 2, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('cliente.compras.show', $compra->id) }}"
                                            class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($compras->hasPages())
                <div class="card-footer">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            {{-- Link para a página anterior --}}
                            @if ($compras->onFirstPage())
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Anterior</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $compras->previousPageUrl() }}"
                                        tabindex="-1">Anterior</a>
                                </li>
                            @endif

                            {{-- Primeiro link --}}
                            @if ($compras->currentPage() > 3)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $compras->url(1) }}">1</a>
                                </li>
                                @if ($compras->currentPage() > 4)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                            @endif

                            {{-- Links das páginas vizinhas --}}
                            @for ($i = max($compras->currentPage() - 2, 1); $i <= min($compras->currentPage() + 2, $compras->lastPage()); $i++)
                                <li class="page-item {{ $i == $compras->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $compras->url($i) }}">{{ $i }}
                                        @if ($i == $compras->currentPage())
                                            <span class="sr-only">(current)</span>
                                        @endif
                                    </a>
                                </li>
                            @endfor

                            {{-- Último link --}}
                            @if ($compras->currentPage() < $compras->lastPage() - 2)
                                @if ($compras->currentPage() < $compras->lastPage() - 3)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $compras->url($compras->lastPage()) }}">{{ $compras->lastPage() }}</a>
                                </li>
                            @endif

                            {{-- Link para a próxima página --}}
                            @if ($compras->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $compras->nextPageUrl() }}">Próxima</a>
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
            height: 200px;
            object-fit: cover;
        }
    </style>
@endsection
