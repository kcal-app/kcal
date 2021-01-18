<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        @isset($styles) {{ $styles }} @endisset
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
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
                    <div class="bg-green-200 p-2 mb-2">
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
                {{ $slot }}
            </main>
        </div>

        @isset($scripts) {{ $scripts }} @endisset
        @livewireScripts
    </body>
</html>
