@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4 sm:p-6 min-h-screen">

    {{-- ▼ ナビゲーション --}}
    <nav class="mb-8 flex justify-between items-center">
        <a href="{{ route('threads.index') }}" class="text-orange-600 font-bold flex items-center hover:underline">
            <span class="mr-1">←</span> 募集一覧へ戻る
        </a>
    </nav>

    {{-- ▼ フラッシュメッセージ --}}
    @if (session('message'))
        <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6 font-bold text-center border border-green-200 shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    {{-- ▼ メインコンテンツ --}}
    <div class="bg-white rounded-3xl shadow-xl border border-orange-50 overflow-hidden mb-12">
        <div class="bg-gradient-to-r from-orange-400 to-yellow-400 h-3"></div>

        <div class="p-6 sm:p-10">

            {{-- ヘッダー --}}
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-orange-100 text-orange-500 rounded-full flex items-center justify-center mr-4 text-2xl">
                        👤
                    </div>

                    <div>
                        <div class="font-bold text-gray-700 text-xl">
                            {{ $thread->user->name ?? '募集主さん' }}
                        </div>
                        <div class="text-xs text-gray-400">
                            投稿日：{{ $thread->created_at->format('Y/m/d H:i') }}
                        </div>
                    </div>
                </div>

                @if(auth()->id() === $thread->user_id)
                    <form action="{{ route('threads.destroy', $thread) }}" method="POST"
                          onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button class="text-gray-400 hover:text-red-600 text-sm font-bold">
                            🗑 削除
                        </button>
                    </form>
                @endif
            </div>

            <h1 class="text-3xl font-black text-gray-800 mb-6">
                {{ $thread->title }}
            </h1>

            @if($thread->image)
                <div class="mb-6">
                    <img src="{{ asset('storage/'.$thread->image) }}"
                         class="rounded-2xl w-full max-h-[500px] object-cover">
                </div>
            @endif

            <div class="bg-orange-50 rounded-2xl p-6 text-gray-700 whitespace-pre-wrap">
                {{ $thread->body }}
            </div>
        </div>
    </div>

    {{-- ▼ 興味あり機能エリア --}}
    @auth

        {{-- 他人の投稿の場合 --}}
        @if (auth()->id() !== $thread->user_id)

            {{-- 興味ありが有効な投稿のみボタン表示 --}}
            @if ($thread->enable_interest)

                <div class="mb-12">

                    {{-- まだ送ってない --}}
                    @if (!$interest)
                        <div class="bg-white p-8 rounded-3xl shadow text-center">

                            <h3 class="text-xl font-bold mb-4">
                                この募集が気になりますか？
                            </h3>

                            <form method="POST" action="{{ route('threads.interest.store', $thread) }}">
                                @csrf
                                <button class="bg-pink-500 text-white font-bold text-xl px-10 py-4 rounded-full">
                                    ❤️ 興味ありを送る
                                </button>
                            </form>
                        </div>

                    {{-- 承認待ち --}}
                    @elseif ($interest->status === 'pending')
                        <div class="bg-gray-100 p-6 rounded-2xl text-center">
                            <p class="font-bold text-gray-600">
                                ✅ 興味ありを送信済み（承認待ち）
                            </p>
                        </div>

                    {{-- マッチング成立 --}}
                    @elseif ($interest->status === 'approved')
                        <div class="bg-green-100 p-6 rounded-2xl text-center">
                            <p class="font-bold text-green-700">
                                🎉 マッチング成立！
                            </p>
                        </div>

                    {{-- 見送り --}}
                    @elseif ($interest->status === 'rejected')
                        <div class="bg-gray-100 p-6 rounded-2xl text-center">
                            <p class="text-gray-600">
                                今回は見送りとなりました
                            </p>
                        </div>
                    @endif

                </div>

            {{-- 興味ありが無効の投稿 --}}
            @else
                <div class="mb-12 bg-gray-50 border border-gray-200 rounded-2xl p-6 text-center">
                    <p class="text-gray-500 font-bold">
                        この募集では「興味あり機能」は使用できません
                    </p>
                </div>
            @endif

        {{-- 自分の投稿の場合 --}}
        @else
            <div class="mb-12 bg-orange-50 border border-orange-100 rounded-2xl p-6 text-center">
                <p class="font-bold text-orange-800">
                    📢 これはあなたの募集投稿です
                </p>
            </div>
        @endif

    @endauth

    {{-- ▼ コメント欄 --}}
    <section class="max-w-3xl mx-auto">
        <h3 class="text-2xl font-bold mb-6">
            コメント
        </h3>

        @auth
            <form action="{{ route('threads.comments.store', $thread) }}" method="POST">
                @csrf

                <textarea name="body"
                          class="w-full border p-3 rounded-xl mb-4"
                          rows="3"
                          required></textarea>

                <button class="bg-orange-500 text-white px-6 py-2 rounded-xl">
                    送信
                </button>
            </form>
        @endauth

        <div class="mt-8 space-y-4">
            @foreach ($thread->comments as $comment)
                <div class="border p-4 rounded-xl">
                    <div class="text-sm text-gray-500">
                        {{ $comment->user->name }} さん
                    </div>
                    <div>
                        {!! nl2br(e($comment->body)) !!}
                    </div>
                </div>
            @endforeach
        </div>

    </section>

</div>
@endsection
