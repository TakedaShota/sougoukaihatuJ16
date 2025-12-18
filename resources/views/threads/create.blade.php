@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 text-lg">

    <h1 class="text-2xl font-bold mb-6">スレッドを作成する</h1>

    {{-- エラー表示 --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 border border-red-300 rounded text-red-700">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('threads.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- タイトル --}}
        <label class="block mb-2 font-bold">タイトル</label>
        <input type="text"
               name="title"
               value="{{ old('title') }}"
               class="w-full border p-3 mb-4 text-lg rounded"
               required>

        {{-- 内容 --}}
        <label class="block mb-2 font-bold">内容</label>
        <textarea name="body"
                  rows="5"
                  class="w-full border p-3 mb-4 text-lg rounded"
                  required>{{ old('body') }}</textarea>

        {{-- 写真 --}}
        <label class="block mb-2 font-bold">写真（任意）</label>
        <input type="file" name="image" class="mb-4 text-lg">

        {{-- 興味あり表示選択 --}}
        <label class="flex items-center mb-6">
            <input type="checkbox"
                   name="enable_interest"
                   value="1"
                   class="mr-2"
                   {{ old('enable_interest') ? 'checked' : '' }}>
            この投稿に「興味あり」ボタンを表示する
        </label>

        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded text-lg font-bold">
            投稿する
        </button>
    </form>

</div>
@endsection
