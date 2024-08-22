@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center mt-5">
            <h1>Compre por Categorias</h1>
        </div>
        <div id="carouselCategorias" class="carousel slide mt-4">
            <div class="carousel-inner">
                @foreach ($categorias->chunk(4) as $chunkIndex => $chunk)
                    <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                        <div class="d-flex justify-content-start">
                            @foreach ($chunk as $categoria)
                                <a href="{{route('cliente.produtos.index')}}">
                                    <div class="me-2 border-0 d-flex flex-column align-items-center " style="width: 150px;">
                                        <img src="{{ $categoria->getIconeUrlAttribute() }}"
                                            class="rounded-circle "width="100px" height="100px"
                                            alt="{{ $categoria->nome }}">
                                        <div class="">
                                            <h5 class="mt-3">{{ $categoria->nome }}</h5>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselCategorias" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselCategorias" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
@endsection
