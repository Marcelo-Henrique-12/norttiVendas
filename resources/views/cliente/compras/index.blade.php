@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Compras Realizadas</h3>

        @if (!$compras)
            <div class="alert alert-warning" role="alert">
                Sem compras realizadas!
            </div>
        @else
            <div class="row mt-4">
                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Valor Total</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($compras as $compra)
                                <tr>
                                    <td>{{ $compra->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>R$ {{ number_format($compra->total , 2, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('cliente.compras.show', $compra->id) }}" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('styles')
    <style>
        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
    </style>
@endsection
