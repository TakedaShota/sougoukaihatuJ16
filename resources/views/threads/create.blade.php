@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto p-4 sm:p-6 min-h-screen">

    {{-- 募集一覧に戻る --}}
    <nav class="mb-8">
        <a href="{{ route('threads.index') }}"
           class="inline-flex items-center text-orange-600 font-bold hover:underline">
            ← 募集一覧に戻る
        </a>
    </nav>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-3xl shadow-2xl p-10 border border-gray-100">

            {{-- ヘッダー --}}
            <div class="text-center mb-8">
                <span class="text-5xl">🤝</span>
                <h1 class="text-3xl font-black text-gray-800 mt-4">仲間を募る</h1>
                <p class="text-gray-500">あなたの好きなことを書いて、仲間を見つけましょう。</p>
            </div>

            {{-- エラー表示 --}}
            @if ($errors->any())
                <div class="mb-8 p-4 bg-red-50 border border-red-200 rounded-2xl text-red-700 font-bold">
                    <div class="flex items-center mb-2">
                        <span class="text-xl mr-2">⚠️</span>
                        <span>入力内容を確認してください</span>
                    </div>
                    <ul class="list-disc list-inside text-sm font-normal ml-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- フォーム --}}
            <form action="{{ route('threads.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                {{-- タイトル --}}
                <div>
                    <label class="block font-black text-gray-700 mb-3 text-xl">何をしますか？（募集のタイトル）</label>
                    <input type="text"
                           name="title"
                           value="{{ old('title') }}"
                           required
                           class="w-full border-2 border-gray-100 rounded-2xl p-5 text-xl focus:border-orange-400 focus:ring-0 transition"
                           placeholder="例：週末に公園で将棋をしませんか？">
                </div>

                {{-- 内容 --}}
                <div>
                    <label class="block font-black text-gray-700 mb-3 text-xl">詳しい内容</label>
                    <textarea name="body"
                              rows="6"
                              required
                              class="w-full border-2 border-gray-100 rounded-2xl p-5 text-xl focus:border-orange-400 focus:ring-0 transition"
                              placeholder="場所や時間、どんな初心者でも大丈夫かなど、優しく書いてみましょう。">{{ old('body') }}</textarea>
                </div>

                {{-- 写真（任意） --}}
                <div>
                    <label class="block font-black text-gray-700 mb-3 text-xl">写真（任意）</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-4 bg-gray-50 hover:bg-white hover:border-orange-300 transition">
                        <input type="file" name="image" class="w-full text-gray-500 text-lg file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                        <p class="text-sm text-gray-400 mt-2 ml-1">※活動のイメージ画像があれば登録できます</p>
                    </div>
                </div>

                {{-- 興味あり設定 --}}
                <div class="bg-orange-50 rounded-2xl p-4 border border-orange-100">
                    <label class="flex items-center text-lg font-bold text-gray-700 cursor-pointer">
                        <input type="checkbox"
                               name="enable_interest"
                               value="1"
                               class="w-6 h-6 text-orange-500 border-gray-300 rounded focus:ring-orange-500 mr-3"
                               {{ old('enable_interest', true) ? 'checked' : '' }}>
                        この投稿に「興味あり」ボタンを表示する
                    </label>
                    <p class="text-sm text-gray-500 mt-1 ml-9">
                        チェックを外すと、コメント（質問）のみ受け付けます。
                    </p>
                </div>

                {{-- 送信ボタン --}}
                <button type="submit"
                        class="w-full bg-orange-500 text-white font-black py-5 rounded-2xl text-2xl shadow-xl hover:bg-orange-600 transform hover:scale-[1.02] transition flex items-center justify-center">
                    <span class="mr-2">📣</span>
                    募集を広場に貼り出す
                </button>

            </form>
        </div>
    </div>
</div>
@endsection