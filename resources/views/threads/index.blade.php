@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-4 sm:p-8 min-h-screen">

    {{-- キャッチコピー --}}
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-orange-600 mb-3 tracking-tighter">
            余生～ファイナルマッチ～
        </h1>
        <p class="text-gray-600 text-lg">
            「ひとりより、ふたり。」好きなことを一緒に楽しみませんか？
        </p>
    </div>

    {{-- 仲間募集ボタン --}}
    <div class="flex justify-center mb-12">
        <a href="{{ route('threads.create') }}"
           class="bg-orange-500 hover:bg-orange-600 text-white text-xl font-bold py-5 px-12 rounded-2xl shadow-xl transform hover:-translate-y-1 transition duration-200 flex items-center">
            <span class="text-2xl mr-3">📣</span> 仲間を募集する
        </a>
    </div>

    {{-- 募集一覧 --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($threads as $thread)
            <div class="bg-white border-2 border-orange-100 rounded-3xl p-6 shadow-sm hover:shadow-2xl transition-all relative overflow-hidden group">

                {{-- 装飾 --}}
                <div class="absolute top-0 right-0 w-16 h-16 bg-orange-50 rounded-bl-full -mr-4 -mt-4 transition-colors group-hover:bg-orange-100"></div>

                {{-- カテゴリ --}}
                <div class="mb-4">
                    <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        募集中の趣味
                    </span>
                </div>

                {{-- タイトル --}}
                <h2 class="text-2xl font-bold text-gray-800 mb-2 group-hover:text-orange-600 transition">
                    <a href="{{ route('threads.show', $thread) }}">
                        {{ $thread->title }}
                    </a>
                </h2>

                {{-- 投稿者 + 投稿日（★ 追加ポイント） --}}
                <div class="flex items-center text-sm text-gray-500 mb-4">
                    <span class="mr-4">
                        👤 投稿者：
                        <span class="font-bold text-gray-700">
                            {{ $thread->user?->name ?? '名無しさん' }}
                        </span>
                    </span>
                    <span>
                        🕒 {{ $thread->created_at->diffForHumans() }}
                    </span>
                </div>

                {{-- 本文 --}}
                <p class="text-gray-600 text-lg leading-relaxed line-clamp-2 mb-6">
                    {{ $thread->body }}
                </p>

                {{-- フッター --}}
                <div class="flex items-center justify-between mt-auto border-t border-gray-50 pt-5">
                    <div class="flex items-center text-sm text-gray-500">
                        <span class="bg-gray-100 p-2 rounded-lg mr-3">
                            💬 {{ $thread->comments_count ?? 0 }}人が関心あり
                        </span>
                    </div>
                    <span class="text-orange-600 font-bold group-hover:translate-x-1 transition-transform">
                        詳しく見る →
                    </span>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-white rounded-3xl border-4 border-dotted border-gray-100">
                <p class="text-2xl text-gray-400 font-bold">
                    まだ募集がありません。<br>
                    あなたの趣味をみんなに教えてくれませんか？
                </p>
            </div>
        @endforelse
    </div>

</div>
@endsection
