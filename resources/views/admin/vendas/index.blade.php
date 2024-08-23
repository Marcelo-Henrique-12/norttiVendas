@extends('adminlte::page')

@section('title', 'Vendas')

@section('content_header')
    <h1>Vendas</h1>
@stop

@section('content')
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Pesquisar Vendas</h3>
        </div>
        <form id="search_form" class="needs-validation" action="{{ route('admin.vendas.index') }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3 form-group">
                        <label for="cliente">Nome do cliente</label>
                        <input type="search" class="form-control" id="textfield1" name="cliente"
                            value="{{ request()->cliente ?? '' }}" placeholder="Nome do cliente">
                    </div>

                    <div class="col-sm-3 form-group">
                        <label for="nome">Categoria</label>
                        <div class="d-flex align-items-center">
                            <select name="categoria_id" id="categoria_id" class="form-control">
                                <option selected value=""></option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}"
                                        {{ (int) old('categoria_id', request()->categoria_id) === $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for="nome">Produtos</label>
                        <div class="d-flex align-items-center">
                            <select name="produto_id" id="produto_id" class="form-control">
                                <option selected value=""></option>
                                @foreach ($produtosVendidos as $produto)
                                    <option value="{{ $produto->id }}"
                                        {{ (int) old('produto_id', request()->produto_id) === $produto->id ? 'selected' : '' }}>
                                        {{ $produto->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-outline-info float-right"><i class="fas fa-search"></i>
                    Pesquisar</button>
                <a class="btn btn-outline-danger float-right" href="{{ route('admin.vendas.index') }}"
                    style="margin-right: 10px;"><i class="fas fa-times"></i> Limpar Campos</a>
            </div>
        </form>
    </div>
    <div class="card card-secondary card-outline">
        <div class="card-body table-responsive p-0">
            @if ($vendas->count() > 0)
                <table class="table table-bordered table-striped dataTable dtr-inline">
                    <thead>
                        <tr>
                            <th style="width: 1%;">ID</th>
                            <th>Cliente</th>
                            <th style="width: 10%;">Valor Total</th>
                            <th style="width: 10%;">Data</th>
                            <th style="width: 1%;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vendas as $venda)
                            <tr>
                                <td>{{ $venda->id }}</td>
                                <td>{{ $venda->user->name }}</td>
                                <td>R${{ number_format($venda->total, 2, ',', '.') }} </td>
                                <td>{{ $venda->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.vendas.show', $venda->id) }}" type="button"
                                            class="btn btn-default" title="Visualizar">
                                            <i class="far fa-eye"></i>
                                        </a>

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
