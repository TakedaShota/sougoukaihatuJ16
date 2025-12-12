@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-4">

    {{-- スレッドのタイトルと本文 --}}
    <h1 class="text-2xl font-bold mb-2">{{ $thread->title }}</h1>
    <p class="mb-4">{{ $thread->body }}</p>

    {{-- コメント投稿フォーム --}}
    <div class="mb-6 p-4 bg-gray-100 rounded">
        <form action="{{ route('threads.comments.store', $thread) }}" method="POST">
            @csrf
            {{-- スレッドID（hidden） --}}
            <input type="hidden" name="thread_id" value="{{ $thread->id }}">

            <textarea name="body" rows="3" placeholder="コメントを書く..." required
                class="w-full px-3 py-2 border rounded mb-2"></textarea>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                コメント投稿
            </button>
        </form>
    </div>

    <h3 class="text-xl font-semibold mb-3">コメント一覧</h3>

    @php
        // 親コメントだけ取得し、リレーションで子コメントも取得
        $comments = $thread->comments()->with('user', 'replies.user')->latest()->get();
    @endphp

    @forelse ($comments as $comment)
        <div class="border-b pb-3 mb-3">
            <p class="mb-1">{{ $comment->body }}</p>
            <small class="text-gray-600">
                投稿者: {{ $comment->user->name ?? '匿名' }} |
                {{ $comment->created_at->format('Y-m-d H:i') }}
            </small>

            {{-- コメント削除ボタン（投稿者のみ） --}}
            @can('delete', $comment)
            <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('コメントを削除しますか？');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500">削除</button>
            </form>
            @endcan

            {{-- 返信があれば表示 --}}
            @foreach ($comment->replies as $reply)
                <div class="ml-4 mt-2 p-2 bg-gray-50 border-l">
                    <p class="mb-1">{{ $reply->body }}</p>
                    <small class="text-gray-500">
                        投稿者: {{ $reply->user->name ?? '匿名' }} |
                        {{ $reply->created_at->format('Y-m-d H:i') }}
                    </small>

                    {{-- 返信削除ボタン（投稿者のみ） --}}
                    @can('delete', $reply)
                    <form action="{{ route('comments.destroy', $reply) }}" method="POST" onsubmit="return confirm('コメントを削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500">削除</button>
                    </form>
                    @endcan
                </div>
            @endforeach
        </div>
    @empty
        <p class="text-gray-500">まだコメントはありません。</p>
    @endforelse

    {{-- スレッド削除ボタン（投稿者のみ） --}}
    @can('delete', $thread)
    <form action="{{ route('threads.destroy', $thread) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">スレッドを削除</button>
    </form>
    @endcan

</div>
@endsection
