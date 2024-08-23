@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="mb-5 d-flex justify-content-center">
            <h2 class="mb-5">Compre por categorias</h2>
        </div>

        <div class="row justify-content-start mt-5">
            @foreach ($categorias as $categoria)
                <div class="col-md-4 col-lg-3 col-xl-2 d-flex mb-4">
                    <!-- Link atualizado com o filtro da categoria -->
                    <a href="{{ route('cliente.produtos.index', ['categoria_id' => $categoria->id]) }}" class="categoria-link">
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
