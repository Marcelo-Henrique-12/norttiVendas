@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <h1>Editar Produto</h1>
@stop

@section('content')
    <div class="card card-secondary card-outline">

        <div class="card-body">

            <div class="row">
                <div class="form-group col-md-6 d-flex justify-content-start align-items-center">
                    <img id="foto-preview" src="{{ $produto->getFotoUrlAttribute() }}" alt="Prévia do Foto"
                        class="img-thumbnail" style="max-width: 250px; max-height: 250px;">
                </div>
            </div>

            <div class="row">

                <div class="form-group col-md-6 d-flex justify-content-start align-items-center">
                    <img id="foto-preview" src="#" alt="Prévia do Foto" class="img-thumbnail"
                        style="display: none; max-width: 250px; max-height: 250px;">
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 form-group">
                    <label for="nome">Nome</label>
                    <input disabled type="text" class="form-control @error('nome') is-invalid @enderror" name="nome"
                        placeholder="Nome do produto" value="{{ old('nome', $produto->nome) ?? '' }}">
                </div>
            </div>


            <div class="row">
                <div class="form-group col-xl-4 ">
                    <label for="categoria_id">Categoria do Produto</label>
                    <div class="d-flex align-items-center">
                        <select disabled name="categoria_id" id="categoria_id" class="form-control">
                            <option selected value=""> {{ $produto->categoria->nome }}</option>

                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group d-flex align-items-end">
                    <div class="">
                        <img id="categoria-icon" src="{{ $produto->categoria->getIconeUrlAttribute() }}"
                            alt="Ícone da Categoria" style=" margin-left: 10px; width: 50; height: 50px;">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-4 form-group">
                    <label for="valor">Valor</label>
                    <input disabled type="text" class="form-control @error('valor') is-invalid @enderror" id="valor"
                        name="valor" placeholder="Valor do produto"
                        value="{{ old('valor', number_format($produto->valor, 2, ',', '.')) }}">
                </div>
            </div>


            <div class="row">
                <div class="col-xl-4 form-group">
                    <label for="quantidade">Quantidade Disponível</label>
                    <input disabled type="number" class="form-control @error('quantidade') is-invalid @enderror"
                        id="quantidade" name="quantidade" placeholder="Quantidade do produto em estoque"
                        value="{{ old('quantidade', $produto->quantidade) ?? '' }}">
                </div>

            </div>
            <div class="card-footer">
                <a href="{{ route('admin.produtos.index') }}" type="button" class="btn btn-secondary">Voltar</a>
                <a href="{{ route('admin.produtos.edit', $produto->id) }}" type="button" class="btn btn-success">Editar</a>
            </div>
        </div>
    </div>
@stop
