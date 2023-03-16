<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite('resources/sass/app.scss')

    @vite('resources/js/app.js')

    @livewireStyles
</head>
<body class="flex flex-col h-screen">
<main {{ $attributes }}>
{{ $slot }}
</main>
</body>
@livewireScripts
</html>
