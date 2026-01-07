@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 text-lg">
    <div class="bg-white rounded-3xl shadow-2xl p-10 border border-gray-100">

        <div class="text-center mb-8">
            <span class="text-5xl">🤝</span>
            <h1 class="text-3xl font-black text-gray-800 mt-4">スレッドを作成する</h1>
            <p class="text-gray-500">内容を書いて投稿しましょう。</p>
        </div>

        {{-- エラー表示 --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-300 rounded text-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('threads.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- タイトル --}}
            <div>
                <label class="block font-black text-gray-700 mb-3 text-xl">タイトル</label>
                <input type="text"
                       name="title"
                       value="{{ old('title') }}"
                       required
                       class="w-full border-2 border-gray-100 rounded-2xl p-5 text-xl focus:border-orange-400 focus:ring-0 transition">
            </div>

            {{-- 内容 --}}
            <div>
                <label class="block font-black text-gray-700 mb-3 text-xl">内容</label>
                <textarea name="body"
                          rows="6"
                          required
                          class="w-full border-2 border-gray-100 rounded-2xl p-5 text-xl focus:border-orange-400 focus:ring-0 transition">{{ old('body') }}</textarea>
            </div>

            {{-- 写真 --}}
            <div>
                <label class="block font-black text-gray-700 mb-3 text-xl">写真（任意）</label>
                <input type="file" name="image" class="text-lg">
            </div>

            {{-- 興味あり --}}
            <label class="flex items-center text-lg">
                <input type="checkbox"
                       name="enable_interest"
                       value="1"
                       class="mr-3"
                       {{ old('enable_interest') ? 'checked' : '' }}>
                この投稿に「興味あり」ボタンを表示する
            </label>

            <button type="submit"
                class="w-full bg-orange-500 text-white font-black py-5 rounded-2xl text-2xl shadow-xl hover:bg-orange-600 transform hover:scale-[1.02] transition">
                投稿する
            </button>
        </form>
    </div>
</div>
@endsection
