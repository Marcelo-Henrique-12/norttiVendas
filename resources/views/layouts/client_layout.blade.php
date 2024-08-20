<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('adminlte.title', 'AdminLTE 3') }}</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="@yield('classes_body')" @yield('body_data')>

<div class="wrapper">

    {{-- Top Navbar --}}
    @include('adminlte::partials.navbar.navbar', ['layout_topnav' => true])

    {{-- Content Wrapper. Contains page content --}}
    <div class="content-wrapper @yield('classes_content_wrapper')" @yield('content_wrapper_data')>
        <div class="@yield('classes_content_header')" @yield('content_header_data')>
            @yield('content_header')
        </div>

        <div class="content @yield('classes_content')" @yield('content_data')>
            @yield('content')
        </div>
    </div>
    {{-- /.content-wrapper --}}

    {{-- Footer --}}
    @hasSection('footer')
        @include('adminlte::partials.footer.footer')
    @endif
</div>

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
