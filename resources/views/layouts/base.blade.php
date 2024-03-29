<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(request()->header('X-Forwarded-Proto') == 'https')
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
    @hasSection('title')

    <title>@yield('title') - {{ config('app.name') }}</title>
    @else
    <title>{{ config('app.name') }}</title>
    @endif

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url(asset('favicon.ico')) }}">

    <!-- Fonts -->
    {{--
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css"> --}}

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    {{-- <script src="https://cdn.tailwindcss.com/3.4.1"></script> --}}



    {{-- @livewireStyles
    @livewireScripts --}}

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="flex flex-col">
    @include('layouts.navbar')
    @yield('body')
    @include('layouts.footer')
</body>

</html>
