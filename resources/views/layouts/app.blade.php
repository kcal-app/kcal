<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }} - {{ config('app.name') }}</title>

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest.json') }}">
        <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}'" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
        <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="msapplication-starturl" content="/">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @stack('styles')

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>

        <!-- Page Content -->
        <main>
            @if(session()->has('message'))
                <div class="bg-emerald-200 p-2 mb-2">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="flex flex-col">
                    <div class="font-extrabold bg-red-200 p-2 text-lg">Errors!</div>
                    @foreach ($errors->all() as $error)
                        <div class="bg-red-200 p-2">
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="{{ !isset($feature_image) ? 'pt-6 ' : '' }}max-w-7xl mx-auto sm:px-6 lg:px-8">
                @isset($feature_image)
                    <div class="h-32 bg-cover bg-no-repeat bg-center bg-clip-border sm:h-48 md:h-64 lg:h-96" style="background-image: url('{{ $feature_image }}')"></div>
                @endisset
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <article class="p-6 border-b border-gray-200">
                        {{ $slot }}
                    </article>
                </div>
            </div>
        </main>
    @stack('scripts')
    </body>
</html>
