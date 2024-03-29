<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
{{--        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">--}}
        <link rel="shortcut icon" href="{{ URL::asset('assets/favicon/favicon-16x16.png') }}" />
{{--        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">--}}

        <title>@yield('title')</title>

        <style>[x-cloak] { display: none !important; }</style>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body x-data="{ mode: 'dark' }" :class="mode=== 'dark' ? 'dark bg-gray-800' : 'light bg-white'" class="font-sans">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @livewire('notifications')
        @livewireScripts
        @stack('scripts')
    </body>
</html>
