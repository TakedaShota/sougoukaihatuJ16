@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-4 sm:p-8 min-h-screen">

    {{-- キャッチコピー --}}
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-orange-600 mb-3 tracking-tighter">
            趣味の仲間づくり広場
        </h1>
        <p class="text-gray-600 text-lg">
            「ひとりより、ふたり。」好きなことを一緒に楽しみませんか？
        </p>
    </div>

    {{-- 投稿ボタン --}}
    <div class="flex justify-center mb-12">
        <a href="{{ route('threads.create') }}"
           class="bg-orange-500 hover:bg-orange-600 text-white text-xl font-bold py-5 px-12 rounded-2xl shadow-xl transform hover:-translate-y-1 transition flex items-center">
            <span class="text-2xl mr-3">📣</span> 仲間を募集する
        </a>
    </div>

    {{-- 投稿一覧 --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($threads as $thread)
            <div class="bg-white border-2 border-orange-100 rounded-3xl p-6 shadow-sm hover:shadow-2xl transition-all relative overflow-hidden group">

                {{-- 新着 --}}
                @if($thread->created_at->gt(now()->subHour()))
                    <span class="absolute top-4 left-4 bg-red-600 text-white text-xs px-3 py-1 rounded-full">
                        新着
                    </span>
                @endif

                {{-- タイトル --}}
                <h2 class="text-2xl font-bold text-gray-800 mb-3 group-hover:text-orange-600 transition">
                    <a href="{{ route('threads.show', $thread) }}">
                        {{ $thread->title }}
                    </a>
                </h2>

                {{-- 日時・コメント数 --}}
                <p class="text-sm text-gray-500 mb-3">
                    🕒 {{ $thread->created_at->format('Y/m/d H:i') }}
                    ／ 💬 {{ $thread->comments_count }}件
                </p>

                {{-- 画像 --}}
                @if($thread->image)
                    <img src="{{ asset('storage/'.$thread->image) }}"
                         class="rounded-xl mb-4 max-h-48 object-cover cursor-pointer"
                         onclick="window.open(this.src, '_blank')">
                @endif

                {{-- 本文 --}}
                <p class="text-gray-700 leading-relaxed line-clamp-3 mb-6">
                    {{ Str::limit($thread->body, 120) }}
                </p>

                <div class="flex justify-end">
                    <span class="text-orange-600 font-bold group-hover:translate-x-1 transition-transform">
                        詳しく見る →
                    </span>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-white rounded-3xl border-4 border-dotted border-gray-100">
                <p class="text-2xl text-gray-400 font-bold">
                    まだ募集がありません。<br>
                    あなたの趣味をみんなに教えてください！
                </p>
            </div>
        @endforelse
    </div>

    {{-- ページネーション --}}
    <div class="mt-12">
        {{ $threads->links() }}
    </div>

</div>
@endsection
