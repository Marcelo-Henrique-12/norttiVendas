@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
    <h1>Categorias</h1>
@stop

@section('content')
    <div class="card card-secondary card-outline">
        <form action="{{ route('admin.categoria.update',$categoria->id )}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-7 col-md-6 form-group">
                        <label for="nome">Nome<abbr title="Campo Obrigatório" class="text-danger">*</abbr></label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome"
                            placeholder="Nome da Categoria" value="{{old('nome',$categoria->nome) ?? ''}}">
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xl-4 col-md-5" id="icone">
                        <label for="icone">Ícone <abbr title="Campo Obrigatório" class="text-danger">*</abbr></label>
                        <input type="file" class="form-control-file @error('icone') is-invalid @enderror" id="icone"
                            name="icone" accept="image/*" onchange="previewIcon(event)">
                        <small class="text-muted">
                            Tamanho máximo: 2 MB.
                        </small>
                        @error('icone')
                            <div class="invalid-feedback">
                                {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 d-flex justify-content-start align-items-center">
                        <img id="icone-preview" src="{{ asset('storage/' . $categoria->icone) }}" alt="Prévia do Ícone" class="img-thumbnail"
                            style="display: block; max-width: 150px; max-height: 150px;">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-7 col-md-6 form-group">
                        <label for="descricao">Descrição<abbr title="Campo Obrigatório" class="text-danger">*</abbr></label>
                        <input type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao"
                            placeholder="Descrição da Categoria"  value="{{old('descricao',$categoria->descricao) ?? ''}}">
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <a href="{{ route('admin.categoria.index') }}" type="button" class="btn btn-secondary">Voltar</a>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </form>
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
