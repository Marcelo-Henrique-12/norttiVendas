@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
    <h1>Categorias</h1>
@stop

@section('content')
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Pesquisar categorias</h3>
        </div>
        <form id="search_form" class="needs-validation" action="{{ route('admin.categorias.index') }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4 form-group">
                        <label for="nome">Nome da categoria</label>
                        <input type="search" class="form-control" id="textfield1" name="nome"
                            value="{{ request()->nome ?? '' }}" placeholder="Nome da Categoria">
                    </div>
                </div>
                <a href="{{ route('admin.categorias.create') }}" class="btn btn-outline-success"><i class="fas fa-plus"></i>
                    Cadastrar</a>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-outline-info float-right"><i class="fas fa-search"></i>
                    Pesquisar</button>
                <a class="btn btn-outline-danger float-right" href="{{ route('admin.categorias.index') }}"
                    style="margin-right: 10px;"><i class="fas fa-times"></i> Limpar Campos</a>
            </div>
        </form>
    </div>
    <div class="card card-secondary card-outline">
        <div class="card-body table-responsive p-0">
            @if ($categorias->count() > 0)
                <table class="table table-bordered table-striped dataTable dtr-inline">
                    <thead>
                        <tr>
                            <th style="width: 1%;">ID</th>
                            <th style="width: 1%;">Ícone</th>
                            <th>Nome</th>
                            <th style="width: 1%;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categorias as $categoria)
                            <tr>
                                <td>{{ $categoria->id }}</td>
                                <td>
                                    @if ($categoria->icone)
                                        <img src="{{ $categoria->getIconeUrlAttribute() }}" alt="Icone" width="50"
                                            height="50">
                                    @endif
                                </td>

                                <td>{{ $categoria->nome }}</td>

                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.categorias.show', $categoria->id) }}" type="button"
                                            class="btn btn-default" title="Visualizar">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.categorias.edit', $categoria->id) }}" type="button"
                                            class="btn btn-primary" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>

                                        <a href="#" type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#modal-default{{ $categoria->id }}" title="Excluir">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                    <div class="modal fade" id="modal-default{{ $categoria->id }}" style="display: none;"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Excluir Categoria</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Caso prossiga com a exclusão do item, o mesmo não poderá ser mais
                                                        recuperado. Deseja realmente excluir?</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Fechar</button>
                                                    <form method="post"
                                                        action="{{ route('admin.categorias.destroy', $categoria->id) }}"
                                                        novalidate>
                                                        @method('delete')
                                                        @CSRF
                                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

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
            @else
                <div class="p-3 d-flex justify-content-center align-items-center"> <i>Nenhum registro encontrado</i></div>
            @endif
        </div>
    @stop

    @section('js')
        <script>
            function previewIcon(event) {
                var reader = new FileReader();
                reader.onload = function() {
                    var output = document.getElementById('icone-preview');
                    output.src = reader.result;
                    output.style.display = 'block';
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        </script>
    @stop
