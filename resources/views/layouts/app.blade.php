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
<body class="bg-gray-100">

    <!-- ヘッダー -->
    <header class="bg-white shadow">
        <nav class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="text-xl font-bold text-gray-800">
                MyApp
            </div>

            <div class="flex gap-6 text-gray-700 font-semibold">
                <a href="{{ route('threads.index') }}" class="hover:text-blue-600">掲示板</a>
                <a href="/chat" class="hover:text-blue-600">グループチャット</a>
                <a href="/profile" class="hover:text-blue-600">プロフィール</a>
            </div>
        </nav>
    </header>

    <!-- メイン -->
    <main class="min-h-screen py-6">
        @yield('content')
    </main>

    <!-- ページ個別JS -->
    @stack('scripts')

</body>
</html>
