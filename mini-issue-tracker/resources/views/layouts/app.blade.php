<?php

<html lang="tr" class="h-full bg-gray-900 text-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mini Issue Tracker')</title>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="h-full flex flex-col font-sans antialiased selection:bg-indigo-500 selection:text-white">

@include('layouts.partials.navbar')

<main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-950 border border-emerald-500 text-emerald-400 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</main>

@yield('scripts')
</body>
</html>
