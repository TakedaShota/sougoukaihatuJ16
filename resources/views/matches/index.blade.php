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
    
    <div class="max-w-3xl mx-auto px-4">
        <h1 class="text-2xl font-black mb-4">マッチ成立</h1>

        @forelse($matches as $m)
            <div class="bg-white p-4 rounded-xl shadow mb-3 border border-gray-100">
                <div class="font-black text-lg">{{ $m->thread->title }}</div>

                @php
                    $me = auth()->id();
                    $other = ($m->from_user_id === $me) ? $m->toUser : $m->fromUser;
                @endphp

                <div class="mt-2 text-sm text-gray-700">
                    お相手：<span class="font-bold">{{ $other->name }}</span>
                    （部屋：{{ $other->room_number }}）
                </div>

                <div class="mt-2 text-sm text-green-700 font-bold">
                    ✅ マッチ成立
                </div>

                {{-- ▼▼▼ 追加したチャットボタン ▼▼▼ --}}
                <div class="mt-4 pt-3 border-t border-gray-100">
                    <a href="{{ route('chat.show', $m) }}" 
                       class="flex items-center justify-center w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow transition">
                        💬 チャットを開く
                    </a>
                </div>
                {{-- ▲▲▲ ここまで ▲▲▲ --}}

            </div>
        @empty
            <div class="bg-white p-6 rounded-xl shadow text-gray-600">
                まだマッチはありません。
            </div>
        @endforelse
    </div>
</div>
@endsection