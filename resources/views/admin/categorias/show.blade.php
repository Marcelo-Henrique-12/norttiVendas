@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
    <h1>Categorias</h1>
@stop

@section('content')
    <div class="card card-secondary card-outline">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6 d-flex justify-content-start align-items-center">
                        <img id="icone-preview" src="{{ $categoria->getIconeUrlAttribute() }}" alt="Prévia do Ícone" class="img-thumbnail"
                            style="display: block; max-width: 150px; max-height: 150px;">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-7 col-md-6 form-group">
                        <label for="id">Código (Id)</label>
                        <input disabled type="text" class="form-control @error('id') is-invalid @enderror" name="id"
                            placeholder="" value="{{old('id',$categoria->id) ?? ''}}">
                        @error('id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-7 col-md-6 form-group">
                        <label for="nome">Nome</label>
                        <input disabled type="text" class="form-control @error('nome') is-invalid @enderror" name="nome"
                            value="{{old('nome',$categoria->nome) ?? ''}}">
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="row">
                    <div class="col-xl-7 col-md-6 form-group">
                        <label for="descricao">Descrição</label>
                        <input disabled type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao"
                            placeholder="Descrição da Categoria"  value="{{old('descricao',$categoria->descricao) ?? ''}}">
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-7 col-md-6 form-group">
                        <label for="quantidade">Quantidade de Produtos</label>
                        <input disabled type="text" class="form-control @error('quantidade') is-invalid @enderror" name="quantidade"
                            placeholder="Descrição da Categoria"  value="{{old('quantidade',$categoria->produtos->count()) ?? ''}}">
                        @error('quantidade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <a href="{{ route('admin.categorias.index') }}" type="button" class="btn btn-secondary">Voltar</a>
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
