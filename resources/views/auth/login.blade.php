@extends('layouts.guest')

@section('content')
{{-- DEBUG: NEW LOGIN VIEW --}}
<div class="text-center mb-8">
    <div class="text-5xl mb-4">🏠</div>
    <h1 class="text-3xl font-black text-orange-600">団地友達募集サイト</h1>
    <p class="text-gray-500 mt-2">ご近所さんと、ゆるくつながろう</p>
</div>

@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6 text-sm">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('login.post') }}" class="space-y-6">
    @csrf

    <div>
        <label class="block text-sm font-bold text-gray-700 mb-2">電話番号</label>
        <input
            type="text"
            name="phone"
            required
            class="w-full rounded-xl border-gray-200 px-4 py-3 text-lg focus:border-orange-400 focus:ring-orange-200"
            placeholder="090-xxxx-xxxx"
        >
    </div>

    <button
        class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl text-lg font-black shadow-lg transition"
    >
        ログイン
    </button>
</form>

<div class="mt-8 text-center text-sm text-gray-600">
    はじめての方は
    <a href="{{ route('register.form') }}" class="text-orange-600 font-bold hover:underline">
        新規登録
    </a>
</div>
@endsection
