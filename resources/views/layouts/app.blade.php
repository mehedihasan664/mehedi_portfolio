<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Mehedi Hasan portfolio - PHP, Laravel, Livewire, Tailwind CSS, JavaScript, SQL, MySQL, Git, and GitHub developer.">
    <title>{{ $title ?? config('app.name', 'Portfolio') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-zinc-950 text-zinc-100 antialiased">
    {{ $slot }}
    @livewireScripts
</body>
</html>
