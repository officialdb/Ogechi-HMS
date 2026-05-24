<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Ogechi HMS') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="font-sans antialiased hms-admin-body">
        <div class="hms-shell">
            @include('layouts.navigation')

            <main class="lg:pl-80">
                @isset($header)
                    <header class="px-4 pt-6 sm:px-6 lg:px-8">
                        <div class="hms-panel rounded-[1.75rem] px-6 py-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <section>
                    {{ $slot }}
                </section>
            </main>
        </div>
    </body>
</html>
