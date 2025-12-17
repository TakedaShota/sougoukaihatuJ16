@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow text-center">
    <h2 class="text-xl font-bold mb-4">承認待ち</h2>

    <p class="mb-6 text-gray-700">
        現在、管理者による承認待ちです。<br>
        承認されるまでしばらくお待ちください。
    </p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button
            type="submit"
            class="bg-gray-500 text-white px-4 py-2 rounded">
            ログアウト
        </button>
    </form>
</div>
@endsection
