@extends('layouts.app')

@section('content')
{{-- ▼ コンテナの幅を広げ(max-w-3xl)、全体の文字を大きく(md:text-lg)設定 --}}
<div class="max-w-3xl mx-auto p-4 sm:p-8 min-h-screen md:text-lg">
    
     {{-- ▼ ナビゲーション --}}
    <nav class="mb-8 flex justify-between items-center">
        <a href="{{ route('threads.index') }}" class="text-orange-600 font-bold flex items-center hover:underline">
            <span class="mr-1">←</span> 募集一覧へ戻る
        </a>
    </nav>

    <div class="bg-white rounded-[2rem] shadow-xl p-6 md:p-12 border-2 border-orange-50">
        
        <div class="text-center mb-10">
            {{-- 見出しをさらに大きく --}}
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-3">プロフィール編集</h1>
            <p class="text-lg text-gray-500">あなたの魅力を伝えましょう</p>
        </div>

        {{-- 成功メッセージ：文字を大きく --}}
        @if (session('success'))
            <div class="bg-green-100 border-2 border-green-400 text-green-800 px-6 py-4 rounded-xl mb-8 relative text-lg font-bold" role="alert">
                <span class="block sm:inline">✅ {{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- 1. プロフィール画像 --}}
            <div class="mb-12 text-center">
                <label class="block text-gray-800 font-bold mb-4 text-xl">プロフィール画像</label>
                
                {{-- ▼ 【修正】サイズを w-24 h-24 に小さくし、きれいな円形に --}}
                <div class="flex justify-center mb-6">
                    @if($user->image)
                        <img src="{{ asset('storage/' . $user->image) }}" 
                             class="w-24 h-24 md:w-32 md:h-32 rounded-full object-cover border-4 border-orange-200 shadow-md">
                    @else
                        <div class="w-24 h-24 md:w-32 md:h-32 rounded-full bg-orange-50 flex items-center justify-center text-5xl text-orange-300 border-4 border-orange-200 shadow-inner">
                            👤
                        </div>
                    @endif
                </div>

                {{-- ファイル選択ボタン周りの文字も大きく --}}
                <div class="text-lg">
                    <input type="file" name="image" class="text-gray-500
                    file:mr-4 file:py-3 file:px-6
                    file:rounded-full file:border-0
                    file:text-lg file:font-bold
                    file:bg-orange-100 file:text-orange-700
                    hover:file:bg-orange-200 cursor-pointer">
                </div>
            </div>

            {{-- 2. お名前 --}}
            <div class="mb-10">
                <label for="name" class="block text-gray-800 font-bold mb-3 text-xl">お名前</label>
                {{-- 入力欄を大きく、文字も大きく --}}
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                       class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-2 border-gray-200 text-lg focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none transition-all font-bold text-gray-700">
                @error('name') <p class="text-red-500 text-base font-bold mt-2">⚠️ {{ $message }}</p> @enderror
            </div>

            {{-- 3. 自己紹介 --}}
            <div class="mb-12">
                <label for="introduction" class="block text-gray-800 font-bold mb-3 text-xl">自己紹介・趣味</label>
                <textarea name="introduction" id="introduction" rows="6"
                          class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-2 border-gray-200 text-lg focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none transition-all font-bold text-gray-700 leading-relaxed"
                          placeholder="（例）&#13;&#10;週末はカフェ巡りをしています。&#13;&#10;同じ趣味の方と一緒に楽しみたいです！&#13;&#10;よろしくお願いします。">{{ old('introduction', $user->introduction) }}</textarea>
                @error('introduction') <p class="text-red-500 text-base font-bold mt-2">⚠️ {{ $message }}</p> @enderror
            </div>

            {{-- 更新ボタン --}}
            <div class="text-center">
                {{-- ▼ 【修正】確実に色が出るよう、単色の bg-orange-500 に変更 --}}
                <button type="submit" 
                        class="w-full md:w-auto bg-orange-500 hover:bg-orange-600 text-white text-2xl font-extrabold py-5 px-16 rounded-full shadow-xl transform hover:-translate-y-1 transition duration-200 ring-4 ring-orange-200 ring-offset-2">
                    保存する
                </button>
            </div>

        </form>
    </div>
</div>
@endsection