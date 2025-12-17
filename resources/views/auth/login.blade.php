@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">ログイン</h2>

    @if ($errors->any())
        <div class="bg-red-100 p-3 mb-3 text-red-700 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf

        <label class="block mb-2">電話番号</label>
        <input type="text" name="phone" class="w-full border p-2 rounded mb-4">

        <button class="bg-blue-500 text-white px-4 py-2 rounded w-full">ログイン</button>
    </form>

    <div class="mt-4 text-right">
        <a href="{{ route('register.form') }}" class="text-blue-600">新規登録</a>
    </div>
</div>
@endsection
