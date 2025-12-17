<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- ナビゲーション（不要ならコメントアウト） --}}
    {{-- @include('layouts.navigation') --}}

    <main class="py-10">
        @yield('content')
    </main>

</body>
</html>
