@extends('layouts.guest')

@section('content')
<div class="text-center mb-8">
    <div class="text-5xl mb-4">🤝</div>
    <h1 class="text-3xl font-black text-orange-600">新規登録</h1>
    <p class="text-gray-500 mt-2">まずは簡単な登録から</p>
</div>

@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6 text-sm">
        <ul>
            @foreach ($errors->all() as $error)
                <li>・{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register.store') }}" class="space-y-5">
    @csrf

    <div>
        <label class="block text-sm font-bold text-gray-700 mb-1">名前</label>
        <input type="text" name="name" required
            class="w-full rounded-xl border-gray-200 px-4 py-3">
    </div>

    <div>
        <label class="block text-sm font-bold text-gray-700 mb-1">電話番号</label>
        <input type="text" name="phone" required
            class="w-full rounded-xl border-gray-200 px-4 py-3">
    </div>

    <div>
        <label class="block text-sm font-bold text-gray-700 mb-1">部屋番号</label>
        <input type="text" name="room_number" required
            class="w-full rounded-xl border-gray-200 px-4 py-3">
    </div>

    <div>
        <label class="block text-sm font-bold text-gray-700 mb-1">パスワード</label>
        <input type="password" name="password" required
            class="w-full rounded-xl border-gray-200 px-4 py-3">
    </div>

    <div>
        <label class="block text-sm font-bold text-gray-700 mb-1">パスワード確認</label>
        <input type="password" name="password_confirmation" required
            class="w-full rounded-xl border-gray-200 px-4 py-3">
    </div>

    <button
        class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl text-lg font-black shadow-lg transition"
    >
        登録する
    </button>
</form>

<div class="mt-8 text-center text-sm text-gray-600">
    すでに登録済みの方は
    <a href="{{ route('login') }}" class="text-orange-600 font-bold hover:underline">
        ログイン
    </a>
</div>
@endsection
