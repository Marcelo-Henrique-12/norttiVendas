@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-start">
            @foreach ($produtos as $produto)
                <div class="col-md-3 d-flex mb-4">
                    <div class="card flex-fill position-relative" style="width: 18rem;">
                        @if ($produto->quantidade == 0)
                            <div class="position-absolute top-0 start-0 bg-danger text-white p-2" style="z-index: 1;">
                                <i class="fas fa-lock"></i> Esgotado
                            </div>
                        @endif
                        <img src="{{ $produto->getFotoUrlAttribute() }}" class="card-img-top" alt="{{ $produto->nome }}">
                        <div class="card-body">
                            <h4 class="card-title">{{ $produto->nome }}</h4>
                            <h5 class="card-title">
                                <strong>R$ {{ number_format($produto->valor, 2, ',', '.') }}</strong>
                            </h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <img src="{{ $produto->categoria->getIconeUrlAttribute() }}" alt="Icone" width="30"
                                    height="30">
                                {{ $produto->categoria->nome }}
                            </li>
                            <li class="list-group-item">
                                <div class="form-group">
                                    <label for="nome">Quantidade</label>
                                    <input type="number" class="form-control" name="quantidade" value="1"
                                        min="1" max="{{ $produto->quantidade }}"
                                        {{ $produto->quantidade == 0 ? 'disabled' : '' }}>
                                </div>
                            </li>
                        </ul>
                        <div class="card-body d-flex justify-content-around">
                            <form action="{{ route('cliente.carrinho.adicionar') }}" method="post">
                                @csrf
                                <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                                <input type="hidden" name="quantidade" value="1">
                                <button type="submit" name="action" value="carrinho" class="btn btn-secondary"
                                    {{ $produto->quantidade == 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-plus"></i> Carrinho
                                </button>
                                <button type="submit" name="action" value="comprar" class="btn btn-primary"
                                    {{ $produto->quantidade == 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-plus"></i> Comprar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .card-img-top {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.form-group input[type="number"]').forEach(input => {
                input.addEventListener('input', function() {
                    const quantidade = this.value;
                    const forms = this.closest('.card').querySelectorAll('form');
                    forms.forEach(form => {
                        form.querySelector('input[name="quantidade"]').value = quantidade;
                    });
                });
            });
        });
    </script>
@endsection
