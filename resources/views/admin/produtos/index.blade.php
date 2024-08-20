@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <h1>Produtos</h1>
@stop

@section('content')
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Pesquisar produtos</h3>
        </div>
        <form id="search_form" class="needs-validation" action="{{ route('admin.produtos.index') }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4 form-group">
                        <label for="nome">Nome do produto</label>
                        <input type="search" class="form-control" id="textfield1" name="nome"
                            value="{{ request()->nome ?? '' }}" placeholder="Nome do produto">
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="nome">Categoria</label>
                        <div class="d-flex align-items-center">
                            <select name="categoria_id" id="categoria_id" class="form-control">
                                <option selected value=""></option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}"
                                        {{ (int) old('categoria_id', request()->categoria_id)  === $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.produtos.create') }}" class="btn btn-outline-success"><i class="fas fa-plus"></i>
                    Cadastrar</a>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-outline-info float-right"><i class="fas fa-search"></i>
                    Pesquisar</button>
                <a class="btn btn-outline-danger float-right" href="{{ route('admin.produtos.index') }}"
                    style="margin-right: 10px;"><i class="fas fa-times"></i> Limpar Campos</a>
            </div>
        </form>
    </div>
    <div class="card card-secondary card-outline">
        <div class="card-body table-responsive p-0">
            @if ($produtos->count() > 0)
                <table class="table table-bordered table-striped dataTable dtr-inline">
                    <thead>
                        <tr>
                            <th style="width: 1%;">ID</th>
                            <th style="width: 1%;">Foto</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Quantidade em Estoque</th>
                            <th style="width: 1%;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produtos as $produto)
                            <tr>
                                <td>{{ $produto->id }}</td>
                                <td>
                                    @if ($produto->foto)
                                        <img src="{{ $produto->getFotoUrlAttribute() }}" alt="Icone" width="50"
                                            height="50">
                                    @endif
                                </td>

                                <td>{{ $produto->nome }}</td>


                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $produto->categoria->getIconeUrlAttribute() }}"
                                            alt="Icone" width="50" height="50">
                                        <p class="ml-3">{{ $produto->categoria->nome }}</p>
                                    </div>

                                </td>

                                <td>{{ $produto->quantidade }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.produtos.show', $produto->id) }}" type="button"
                                            class="btn btn-default" title="Visualizar">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.produtos.edit', $produto->id) }}" type="button"
                                            class="btn btn-primary" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>

                                        <a href="#" type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#modal-default{{ $produto->id }}" title="Excluir">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                    <div class="modal fade" id="modal-default{{ $produto->id }}" style="display: none;"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Excluir produto</h4>
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
                                                        action="{{ route('admin.produtos.destroy', $produto->id) }}"
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
