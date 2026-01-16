@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4 sm:p-6 min-h-screen">

    {{-- ▼ ナビゲーション --}}
    <nav class="mb-8 flex justify-between items-center">
        <a href="{{ route('threads.index') }}" class="text-orange-600 font-bold flex items-center hover:underline">
            <span class="mr-1">←</span> 募集一覧へ戻る
        </a>
    </nav>

    {{-- ▼ フラッシュメッセージ（成功・エラー） --}}
    @if (session('message'))
        <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6 font-bold text-center border border-green-200 shadow-sm">
            {{ session('message') }}
        </div>
    @endif
    @if ($errors->has('interest'))
        <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6 font-bold text-center border border-red-200">
            {{ $errors->first('interest') }}
        </div>
    @endif

    {{-- ▼ ① メインコンテンツ（スレッド本体） --}}
    <div class="bg-white rounded-3xl shadow-xl border border-orange-50 overflow-hidden mb-12">
        {{-- 装飾用グラデーションバー --}}
        <div class="bg-gradient-to-r from-orange-400 to-yellow-400 h-3"></div>

        <div class="p-6 sm:p-10">
            {{-- 投稿者ヘッダー & 削除ボタン --}}
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center">
                    {{-- アイコン --}}
                    <div class="w-12 h-12 bg-orange-100 text-orange-500 rounded-full flex items-center justify-center mr-4 text-2xl border border-orange-200">
                        👤
                    </div>
                    
                    {{-- 名前とプロフィールボタンエリア --}}
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            {{-- 名前 --}}
                            <div class="font-bold text-gray-700 text-xl">
                                {{ $thread->user->name ?? '募集主さん' }}
                            </div>

                            {{-- プロフィールボタン（自分以外の時だけ表示） --}}
                            @if(auth()->id() !== $thread->user_id)
                                <a href="{{ route('profile.show', $thread->user) }}" 
                                   class="bg-white border border-orange-400 text-orange-600 hover:bg-orange-50 text-xs font-bold px-3 py-1 rounded-full shadow-sm transition flex items-center">
                                   詳細を見る
                                </a>
                            @endif
                        </div>
                        
                        <div class="text-xs text-gray-400">
                            投稿日：{{ $thread->created_at->format('Y/m/d H:i') }}
                        </div>
                    </div>
                </div>

                {{-- 本人のみ削除ボタン表示 --}}
                @if(auth()->id() === $thread->user_id)
                    <form action="{{ route('threads.destroy', $thread) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button class="text-gray-400 hover:text-red-600 text-sm font-bold transition flex items-center px-3 py-2 rounded-lg hover:bg-red-50">
                            🗑 削除
                        </button>
                    </form>
                @endif
            </div>

            {{-- タイトル --}}
            <h1 class="text-3xl sm:text-4xl font-black text-gray-800 mb-8 leading-tight tracking-tight">
                {{ $thread->title }}
            </h1>

            {{-- 画像（あれば表示・クリックで拡大） --}}
            @if($thread->image)
                <div class="mb-8">
                    <img src="{{ asset('storage/'.$thread->image) }}"
                         class="rounded-2xl w-full max-h-[500px] object-cover shadow-sm border border-gray-100 cursor-zoom-in hover:opacity-95 transition"
                         onclick="window.open(this.src)"
                         alt="募集画像">
                </div>
            @endif

            {{-- 本文 --}}
            <div class="bg-orange-50/50 rounded-2xl p-6 sm:p-8 text-lg text-gray-700 leading-loose whitespace-pre-wrap border-l-4 border-orange-300">
                {{ $thread->body }}
            </div>
        </div>
    </div>

    {{-- ▼ ② アクションエリア（マッチング・興味あり機能） --}}
    @auth
        {{-- 自分の投稿でない場合 --}}
        @if (auth()->id() !== $thread->user_id)
            <div class="mb-16">
                {{-- A. まだ送っていない場合 --}}
                @if (!$interest)
                    <div class="bg-white p-8 sm:p-10 rounded-3xl shadow-xl border-2 border-pink-100 text-center relative overflow-hidden group">
                        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-pink-300 to-rose-300"></div>
                        
                        <h3 class="text-xl font-bold text-gray-700 mb-6">
                            この募集が気になりますか？
                        </h3>
                        
                        <form method="POST" action="{{ route('threads.interest.store', $thread) }}">
                            @csrf
                            <button class="w-full md:w-2/3 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-black text-2xl py-5 px-8 rounded-full shadow-lg transform hover:-translate-y-1 transition duration-200 flex items-center justify-center mx-auto">
                                <span class="mr-3 text-3xl animate-pulse">❤️</span>
                                興味ありを送る
                            </button>
                        </form>
                        <p class="text-gray-500 mt-4 text-sm">
                            相手に通知が届きます。まずは気持ちを伝えてみましょう！
                        </p>
                    </div>

                {{-- B. 送信済み（承認待ち） --}}
                @elseif ($interest->status === 'pending')
                    <div class="bg-white p-8 rounded-3xl shadow border-2 border-gray-200 text-center">
                        <div class="inline-block bg-gray-100 text-gray-500 font-bold px-6 py-2 rounded-full mb-4 text-sm">
                            ステータス：確認待ち
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-2">
                            ✅ 興味ありを送信しました
                        </h3>
                        <p class="text-gray-500 mb-6">
                            募集主さんからの返信をお待ちください。
                        </p>
                        <a href="{{ route('interest.outgoing') }}" class="text-orange-600 font-bold underline hover:text-orange-700">
                            履歴を確認する
                        </a>
                    </div>

                {{-- C. マッチング成立 --}}
                @elseif ($interest->status === 'approved')
                    <div class="bg-green-50 p-8 rounded-3xl shadow border-2 border-green-200 text-center">
                        <div class="text-6xl mb-4">🎉</div>
                        <h3 class="text-2xl font-black text-green-700 mb-3">
                            マッチング成立！
                        </h3>
                        <p class="text-green-800 mb-8 font-bold">
                            おめでとうございます！募集主さんが承認しました。<br>
                            連絡を取り合ってみましょう。
                        </p>
                        <a href="{{ route('matches.index') }}" 
                           class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-10 rounded-2xl shadow transition transform hover:-translate-y-1">
                            🤝 メッセージ画面へ進む
                        </a>
                    </div>

                {{-- D. 見送り --}}
                @elseif ($interest->status === 'rejected')
                    <div class="bg-gray-100 p-6 rounded-3xl text-center border border-gray-200 opacity-75">
                        <p class="font-bold text-gray-600 text-lg">
                            今回は見送りとなりました
                        </p>
                        <a href="{{ route('threads.index') }}" class="inline-block mt-2 text-orange-600 font-bold hover:underline">
                            他の募集を探す →
                        </a>
                    </div>
                @endif
            </div>

        {{-- 自分の投稿の場合 --}}
        @else
            <div class="mb-16 bg-orange-50 border-2 border-orange-100 rounded-3xl p-8 text-center">
                <p class="font-bold text-orange-800 text-xl mb-4">📢 これはあなたの募集投稿です</p>
                <a href="{{ route('interest.incoming') }}" 
                   class="inline-flex items-center justify-center bg-white text-orange-600 font-bold py-4 px-8 rounded-xl border-2 border-orange-200 shadow-sm hover:shadow-md hover:border-orange-400 transition">
                    <span class="text-2xl mr-2">📥</span>
                    届いた「興味あり」を確認する
                </a>
            </div>
        @endif
    @endauth

    {{-- ▼ ③ コメント・質問セクション --}}
    <section class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between border-b-2 border-gray-100 pb-4 mb-8">
            <h3 class="text-2xl font-bold text-gray-700 flex items-center">
                <span class="bg-gray-200 text-gray-600 rounded-lg px-3 py-1 text-base mr-3">
                    {{ $thread->comments->count() }}件
                </span>
                コメント・質問
            </h3>
        </div>

        {{-- コメント投稿フォーム --}}
        @auth
            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm mb-10 focus-within:ring-2 ring-orange-200 ring-offset-2 transition">
                <form action="{{ route('threads.comments.store', $thread) }}" method="POST">
                    @csrf
                    
                    <label class="block text-gray-700 font-bold mb-3 flex items-center">
                        <span class="mr-2">💬</span> 質問やメッセージを送る
                    </label>
                    <textarea
                        name="body"
                        rows="3"
                        placeholder="例：初めまして！参加条件などはありますか？"
                        required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-lg mb-4 resize-none"
                    ></textarea>
                    <button
                        type="submit"
                        class="w-full bg-orange-500 text-white font-bold py-3 rounded-xl shadow hover:bg-orange-600 transition flex items-center justify-center"
                    >
                        送信する
                    </button>
                </form>
            </div>
        @else
            <div class="text-center py-8 bg-gray-50 rounded-xl border border-gray-200 mb-10">
                <p class="text-gray-500">コメントするにはログインが必要です。</p>
                <a href="{{ route('login') }}" class="text-orange-600 font-bold hover:underline">ログインはこちら</a>
            </div>
        @endauth

        {{-- コメント一覧 --}}
        <div class="space-y-6">
            @forelse ($thread->comments as $comment)
                <div class="flex gap-4">
                    {{-- アイコン --}}
                    <div class="shrink-0">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-xl">
                            {{ $comment->user->id === $thread->user_id ? '👤' : '🙋‍♂️' }}
                        </div>
                    </div>
                    
                    {{-- 吹き出し --}}
                    <div class="grow">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-bold text-gray-800 text-sm">
                                {{ $comment->user->name ?? '名無しさん' }}
                            </span>
                            @if($comment->user->id === $thread->user_id)
                                <span class="bg-orange-100 text-orange-600 text-xs px-2 py-0.5 rounded-full font-bold">募集主</span>
                            @endif
                            <span class="text-xs text-gray-400">
                                {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <div class="bg-white rounded-r-2xl rounded-bl-2xl p-4 border border-gray-200 shadow-sm text-gray-700 leading-relaxed">
                            {!! nl2br(e($comment->body)) !!}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10">
                    <p class="text-gray-400">まだコメントはありません。<br>気軽に質問してみましょう！</p>
                </div>
            @endforelse
        </div>
    </section>

</div>
@endsection