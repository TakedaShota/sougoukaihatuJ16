<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="max-w-md mx-auto bg-white shadow p-6 rounded mt-10">

    <h2 class="text-xl font-bold mb-4">新規登録</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul class="text-sm">
                @foreach ($errors->all() as $error)
                    <li>・{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label class="block mt-3">名前</label>
        <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ old('name') }}" required>

        <label class="block mt-3">電話番号</label>
        <input type="text" name="phone" class="w-full border rounded px-3 py-2" value="{{ old('phone') }}" required>

        <label class="block mt-3">部屋番号</label>
        <input type="text" name="room_number" class="w-full border rounded px-3 py-2" value="{{ old('room_number') }}" required>

        <label class="block mt-3">パスワード</label>
        <input type="password" name="password" class="w-full border rounded px-3 py-2" required>

        <label class="block mt-3">パスワード確認</label>
        <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>

        <button class="mt-5 w-full bg-blue-500 text-white py-2 rounded">
            登録する
        </button>
    </form>

</div>

</body>
</html>
