<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    @hasSection('readonly')
<style>
    body {
        user-select: none !important;
        -webkit-user-select: none;
        -webkit-touch-callout: none;
    }
    @media print {
        body { display: none !important; }
    }
</style>
@endhasSection


    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @hasSection('readonly')
<script>
    // Blok klik kanan
    document.addEventListener("contextmenu", e => e.preventDefault());

    // Blok kombinasi keyboard
    document.onkeydown = function(e) {
        if (
            e.ctrlKey && ['s','S','u','U','p','P','c','C'].includes(e.key) ||
            e.key === 'PrintScreen' || e.key === 'F12'
        ) {
            e.preventDefault();
            alert("Aksi ini dinonaktifkan!");
            return false;
        }
    };

    // Deteksi PrintScreen
    document.addEventListener('keyup', function(e) {
        if (e.key === 'PrintScreen') {
            navigator.clipboard.writeText('');
            alert('Print screen dinonaktifkan!');
        }
    });

    // Blok print
    window.print = function() {
        alert('Print telah dinonaktifkan!');
        return false;
    };

    // Blok DevTools
    (function() {
        let devtools = function() {};
        devtools.toString = function() {
            alert('Developer Tools dinonaktifkan!');
        };
        console.log('%c', devtools);
    })();
</script>
@endhasSection


    </body>
</html>
