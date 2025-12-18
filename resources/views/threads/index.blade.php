@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-4 text-base">

    {{-- ヘッダー --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">掲示板</h1>

        {{-- ＋ 投稿ボタン（遷移） --}}
        <a href="{{ route('threads.create') }}"
           class="bg-blue-700 hover:bg-blue-800
                  text-white
                  w-20 h-14
                  rounded-full
                  flex items-center justify-center
                  shadow-lg">
            <span class="text-3xl leading-none">＋</span>
        </a>
    </div>

    {{-- 投稿一覧 --}}
    @foreach($threads as $thread)
        <div class="border rounded-xl p-4 mb-6 bg-white shadow">

            @if($thread->created_at->gt(now()->subHour()))
                <span class="inline-block bg-red-600 text-white px-2 py-1 text-xs rounded">
                    新着
                </span>
            @endif

            <h2 class="text-lg font-bold mt-2">
                {{ $thread->title }}
            </h2>

            <p class="text-gray-600 text-sm mt-1">
                {{ $thread->created_at->format('Y年m月d日 H:i') }}
                ／ 💬 {{ $thread->comments_count }}件
            </p>

            @if($thread->image)
                <img src="{{ asset('storage/'.$thread->image) }}"
                     class="mt-3 max-h-40 rounded cursor-pointer"
                     onclick="window.open(this.src, '_blank')">
            @endif

            <p class="mt-3 leading-relaxed">
                {{ Str::limit($thread->body, 120) }}
            </p>

            <a href="{{ route('threads.show', $thread) }}"
               class="inline-block mt-3 text-blue-700 font-semibold">
                詳細を見る →
            </a>
        </div>
    @endforeach

    {{ $threads->links() }}

</div>
@endsection
