@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4 sm:p-6 min-h-screen">

    {{-- 戻る --}}
    <nav class="mb-8">
        <a href="{{ route('threads.index') }}" class="text-orange-600 font-bold hover:underline">
            ← 募集一覧へ戻る
        </a>
    </nav>

    {{-- スレッド本体 --}}
    <div class="bg-white rounded-3xl shadow-lg border border-orange-50 overflow-hidden mb-10">
        <div class="bg-gradient-to-r from-orange-400 to-yellow-400 h-3"></div>

        <div class="p-8">
            <h1 class="text-3xl font-black text-gray-800 mb-4">
                {{ $thread->title }}
            </h1>

            <p class="text-sm text-gray-500 mb-4">
                投稿日：{{ $thread->created_at->format('Y/m/d H:i') }}
            </p>

            {{-- 画像 --}}
            @if($thread->image)
                <img src="{{ asset('storage/'.$thread->image) }}"
                     class="rounded-xl mb-6 max-h-96 cursor-pointer"
                     onclick="window.open(this.src)">
            @endif

            {{-- 本文 --}}
            <div class="bg-orange-50 rounded-2xl p-6 text-lg leading-loose whitespace-pre-wrap border-l-8 border-orange-200">
                {{ $thread->body }}
            </div>

            {{-- 興味あり --}}
            @if($thread->enable_interest)
                <form action="{{ route('threads.interest', $thread) }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit"
                            class="w-full bg-pink-500 hover:bg-pink-600 text-black font-bold py-4 rounded-xl text-xl">
                        ❤️ 興味あり（{{ $thread->interest_count }}）
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- コメント投稿 --}}
    <section class="mb-10">
        <h2 class="text-2xl font-bold mb-4">参加希望・コメント</h2>

        <form action="{{ route('threads.comments.store', $thread) }}" method="POST"
              class="bg-white rounded-2xl p-6 border-2 border-orange-400 shadow-md">
            @csrf
            <textarea name="body" rows="3" required
                      class="w-full px-4 py-4 rounded-xl border text-lg mb-4"
                      placeholder="例：参加してみたいです！"></textarea>
            <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 rounded-xl text-xl">
                コメントする
            </button>
        </form>
    </section>

    {{-- コメント一覧 --}}
    <section class="space-y-4">
        @forelse($comments as $comment)
            <div class="bg-white rounded-2xl p-5 border shadow"
                 x-data="{ menuOpen: false }">

                <div class="flex justify-between items-start">
                    <p class="text-lg break-words flex-1 mr-4">
                        {{ $comment->body }}
                    </p>

                    {{-- メニュー --}}
                    <div class="relative">
                        <button @click="menuOpen = !menuOpen"
                                class="text-xl font-bold px-2">︙</button>

                        <div x-show="menuOpen" x-cloak
                             @click.away="menuOpen = false"
                             class="absolute right-0 mt-2 w-28 bg-white border rounded shadow z-50 text-sm">
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full text-left px-3 py-2 text-red-600 hover:bg-gray-100">
                                    削除
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <small class="text-gray-500">
                    {{ $comment->created_at->format('Y/m/d H:i') }}
                </small>
            </div>
        @empty
            <p class="text-gray-500">まだコメントはありません。</p>
        @endforelse
    </section>

</div>
@endsection
