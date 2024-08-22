<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        {{-- se a rota não for de login ou registro aparece a navbar --}}
        @if (Route::currentRouteName() != 'login' && Route::currentRouteName() != 'register')
            <nav class="navbar navbar-expand-md navbar-dark bg-dark fs-6">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/produtos') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->

                        <ul class="navbar-nav me-auto ">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('cliente.home') ? 'active' : '' }}" aria-current="page"
                                    href="{{ route('cliente.home') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('cliente.produtos.*') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('cliente.produtos.index') }}">
                                    Produtos
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('cliente.compras.*') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('cliente.compras.index') }}">Compras</a>
                            </li>

                        </ul>


                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('cliente.carrinho.*') ? 'active' : '' }}"
                                        aria-current="page" href="{{ route('cliente.carrinho.index') }}">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        @if (session()->has('carrinho'))
                                            <span class="badge badge-pill badge-danger">
                                                {{ array_sum(array_column(session('carrinho'), 'quantidade')) }}
                                            </span>
                                        @endif
                                    </a>
                                </li>


                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fas fa-user"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>

                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        @endif
        <main class="py-4">
            {{-- Mensagens de sucesso e erro --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 mt-5"
                    role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3 mt-5"
                    role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
    @yield('styles')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 3000); // 3 segundos
        });
    </script>
</body>

</html>
