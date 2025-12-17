@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">スレッド作成</h1>

    <form action="{{ route('threads.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-medium mb-1" for="title">タイトル</label>
            <input type="text" name="title" id="title" required
                class="w-full border rounded px-3 py-2" placeholder="スレッドのタイトル">
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1" for="body">内容</label>
            <textarea name="body" id="body" rows="5" required
                class="w-full border rounded px-3 py-2" placeholder="スレッドの本文"></textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            投稿する
        </button>
    </form>
</div>
@endsection