@extends('layouts.app')

@section('content')
{{-- ▼ 【変更】classに relative を追加しました（右上のボタンを配置するため） --}}
<div class="max-w-5xl mx-auto p-4 sm:p-8 min-h-screen relative">

    {{-- ▼ 【追加】プロフィール編集ボタン（ここから） --}}
    @auth
        <div class="absolute top-4 right-4 md:top-8 md:right-8 z-20">
            <a href="{{ Route::has('profile.edit') ? route('profile.edit') : '#' }}" 
               class="flex items-center gap-1 md:gap-2 bg-white text-gray-600 border-2 border-gray-100 hover:border-orange-300 hover:text-orange-600 px-3 py-2 md:px-5 md:py-2.5 rounded-full shadow-sm hover:shadow-md transition-all group">
                {{-- アイコン：歯車 --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6 text-gray-400 group-hover:text-orange-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-xs md:text-sm font-bold pt-0.5">プロフィール編集</span>
            </a>
        </div>
    @endauth
    {{-- ▲ 【追加】プロフィール編集ボタン（ここまで） --}}

    {{-- ▼ キャッチコピーエリア --}}
    <div class="text-center mb-10 pt-4 md:pt-0"> {{-- モバイルでボタンと被らないよう少し余白調整 --}}
        <h1 class="text-3xl md:text-4xl font-extrabold text-orange-600 mb-3 tracking-tighter">
            余生～ファイナルマッチ～
        </h1>
        <p class="text-gray-600 text-sm md:text-lg">
            「ひとりより、ふたり。」<br class="md:hidden">好きなことを一緒に楽しみませんか？
        </p>
    </div>

    {{-- ▼ ユーザーメニューエリア（ログイン状態によって変化） --}}
    @if(auth()->check() && !auth()->user()->is_admin)
        <div class="mb-12 md:mb-20">
            {{-- メインアクション：仲間を募集する --}}
            <div class="text-center mb-6 md:mb-8">
                <a href="{{ route('threads.create') }}"
                   class="inline-flex items-center justify-center w-full md:w-3/4 bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 px-6 md:py-6 md:px-8 rounded-2xl shadow-xl transform hover:-translate-y-1 transition duration-200">
                    <span class="text-2xl md:text-3xl mr-3 md:mr-4">📣</span>
                    <div class="text-left">
                        <span class="block text-lg md:text-2xl">仲間を募集する</span>
                        <span class="text-xs md:text-sm font-normal text-orange-100 block mt-0.5">あなたの趣味を投稿</span>
                    </div>
                </a>
            </div>

            {{-- サブアクション：3つのボタン（シンプル・大文字版） --}}
            <div class="grid grid-cols-3 gap-3 md:gap-6 w-full mx-auto">
                
                {{-- ① 届いた --}}
                <a href="{{ route('interest.incoming') }}"
                   class="group flex flex-col items-center justify-center py-6 px-2 bg-white border-2 border-pink-100 rounded-2xl shadow-sm hover:shadow-md hover:border-pink-400 transition-all cursor-pointer h-full">
                    {{-- アイコン：大きく、ピンク色に --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 md:h-12 md:w-12 text-pink-500 mb-2 group-hover:scale-110 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                    {{-- 文字：大きく、太く --}}
                    <span class="text-base md:text-xl font-bold text-gray-700 group-hover:text-pink-600">
                        届いた
                    </span>
                </a>

                {{-- ② 成立（真ん中） --}}
                <a href="{{ Route::has('matches.index') ? route('matches.index') : '#' }}"
                   class="group flex flex-col items-center justify-center py-6 px-2 bg-white border-2 border-green-100 rounded-2xl shadow-sm hover:shadow-md hover:border-green-400 transition-all cursor-pointer h-full">
                    {{-- アイコン：大きく、緑色に --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 md:h-12 md:w-12 text-green-500 mb-2 group-hover:scale-110 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-.464 5.535a1 1 0 10-1.415-1.414 3 3 0 01-4.242 0 1 1 0 00-1.415 1.414 5 5 0 007.072 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-base md:text-xl font-bold text-gray-700 group-hover:text-green-600">
                        成立
                    </span>
                </a>

                {{-- ③ 送った --}}
                <a href="{{ route('interest.outgoing') }}"
                   class="group flex flex-col items-center justify-center py-6 px-2 bg-white border-2 border-blue-100 rounded-2xl shadow-sm hover:shadow-md hover:border-blue-400 transition-all cursor-pointer h-full">
                    {{-- アイコン：大きく、青色に --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 md:h-12 md:w-12 text-blue-500 mb-2 group-hover:scale-110 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                    </svg>
                    <span class="text-base md:text-xl font-bold text-gray-700 group-hover:text-blue-600">
                        送った
                    </span>
                </a>

            </div>
        </div>
    @else
        {{-- 未ログイン時のシンプルなボタン --}}
        <div class="flex justify-center mb-20">
            <a href="{{ route('threads.create') }}"
               class="bg-orange-500 hover:bg-orange-600 text-white text-xl font-bold py-5 px-12 rounded-2xl shadow-xl transform hover:-translate-y-1 transition duration-200 flex items-center">
                <span class="text-2xl mr-3">📣</span> 仲間を募集する
            </a>
        </div>
    @endif

    {{-- ▼ 区切り線と見出し --}}
    <div class="border-t-2 border-gray-100 pt-10 mb-8">
        <h2 class="text-xl md:text-2xl font-bold text-gray-700 flex items-center">
            <span class="text-orange-500 mr-2">🧩</span> 新着の募集
        </h2>
    </div>

    {{-- ▼ 募集一覧リスト --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
        @forelse($threads as $thread)

            {{-- カード全体をリンク化 --}}
            <a href="{{ route('threads.show', $thread) }}"
               class="block bg-white border-2 border-orange-100 rounded-3xl p-5 md:p-6 shadow-sm hover:shadow-2xl transition-all relative overflow-hidden group">

                {{-- 装飾: 右上の円 --}}
                <div class="absolute top-0 right-0 w-20 h-20 bg-orange-50 rounded-bl-full -mr-4 -mt-4 transition-colors group-hover:bg-orange-100 z-0"></div>

                <div class="relative z-10">
                    {{-- ① バッジエリア --}}
                    <div class="flex justify-end mb-2">
                        @if($thread->created_at->gt(now()->subHour()))
                            <span class="bg-red-600 text-white text-[10px] md:text-xs font-bold px-2 py-1 md:px-3 rounded-full shadow animate-pulse">
                                NEW!
                            </span>
                        @else
                            <span class="bg-yellow-100 text-yellow-800 text-[10px] md:text-xs font-bold px-2 py-1 md:px-3 rounded-full">
                                募集中
                            </span>
                        @endif
                    </div>

                    {{-- ② タイトル --}}
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-2 md:mb-3 group-hover:text-orange-600 transition">
                        {{ $thread->title }}
                    </h2>

                    {{-- ③ 画像 (崩れ防止設定済み) --}}
                    @if($thread->image)
                        <img src="{{ asset('storage/'.$thread->image) }}"
                             class="w-full h-40 md:h-48 object-cover rounded-xl mb-3 md:mb-4 border border-gray-100">
                    @endif

                    {{-- ④ 本文 (長い場合は省略) --}}
                    <p class="text-gray-600 text-sm md:text-lg leading-relaxed line-clamp-2 mb-3 md:mb-4">
                        {{ \Illuminate\Support\Str::limit($thread->body, 120) }}
                    </p>

                    {{-- ⑤ 投稿者情報 --}}
                    <div class="text-xs md:text-sm text-gray-500 mb-3 md:mb-4 flex items-center">
                        <span class="bg-gray-100 rounded-full p-1 mr-2">👤</span>
                        <span class="font-bold text-gray-700">{{ $thread->user->name ?? '募集主さん' }}</span>
                    </div>

                    {{-- ⑥ フッター (日時・コメント数・リンク) --}}
                    <div class="flex items-center justify-between border-t border-gray-50 pt-3 md:pt-4 mt-auto">
                        <div class="flex items-center text-xs md:text-sm text-gray-500 space-x-2 md:space-x-3">
                            <span class="flex items-center">
                                🕒 {{ $thread->created_at->diffForHumans() }}
                            </span>
                            <span class="flex items-center font-bold text-orange-500">
                                💬 {{ $thread->comments_count ?? 0 }}
                            </span>
                        </div>
                        <span class="text-orange-600 font-bold group-hover:translate-x-1 transition-transform text-xs md:text-sm">
                            見る →
                        </span>
                    </div>
                </div>
            </a>

        @empty
            {{-- 投稿がない場合 --}}
            <div class="col-span-full text-center py-12 md:py-20 bg-white rounded-3xl border-4 border-dotted border-gray-100">
                <p class="text-lg md:text-2xl text-gray-400 font-bold">
                    まだ募集がありません。<br>
                    あなたの趣味をみんなに教えてくれませんか？
                </p>
                <div class="mt-6">
                    <a href="{{ route('threads.create') }}" class="text-orange-500 font-bold hover:underline">
                        一番乗りで投稿する →
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- ▼ ページネーション --}}
    <div class="mt-8 md:mt-12 flex justify-center">
        {{ $threads->links() }}
    </div>

</div>
@endsection