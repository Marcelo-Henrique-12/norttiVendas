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
        <form id="search_form" class="needs-validation" action="{{ route('admin.categoria.index') }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4 form-group">
                        <label for="nome">Nome da categoria</label>
                        <input type="search" class="form-control" id="textfield1" name="nome"
                            value="{{ request()->nome ?? '' }}" placeholder="Nome da Categoria">
                    </div>
                </div>
                <a href="{{ route('admin.categoria.create') }}" class="btn btn-outline-success"><i class="fas fa-plus"></i>
                    Cadastrar</a>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-outline-info float-right"><i class="fas fa-search"></i>
                    Pesquisar</button>
                <a class="btn btn-outline-danger float-right" href="{{ route('admin.categoria.index') }}"
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
                                        <img src="{{ asset('storage/' . $categoria->icone) }}" alt="Icone" width="50"
                                            height="50">
                                    @endif
                                </td>

                                <td>{{ $categoria->nome }}</td>

                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.categoria.show', $categoria->id) }}" type="button"
                                            class="btn btn-default" title="Visualizar">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.categoria.edit', $categoria->id) }}" type="button"
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
                                                        action="{{ route('admin.categoria.destroy', $categoria->id) }}"
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
            @else
                <div class="p-3 d-flex justify-content-center align-items-center"> <i>Nenhum registro encontrado</i></div>
            @endif
        </div>
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
