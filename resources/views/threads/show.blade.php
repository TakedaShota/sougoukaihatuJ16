@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-4 text-lg">

    {{-- スレッド --}}
    <div class="border rounded-xl bg-white shadow mb-6">

        {{-- ヘッダー --}}
        <div class="flex justify-between items-center p-4 border-b">
            <h1 class="text-2xl font-bold break-words">
                {{ $thread->title }}
            </h1>

            {{-- ︙メニュー --}}
            <div class="relative" x-data="{ menuOpen: false }">
                <button @click="menuOpen = !menuOpen"
                        class="text-2xl font-bold px-2">
                    ︙
                </button>

                <div x-show="menuOpen" x-cloak
                     @click.away="menuOpen = false"
                     class="absolute right-0 mt-2 w-36 bg-white border rounded shadow z-50 text-sm">
                    <form action="{{ route('threads.destroy', $thread) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full text-left px-3 py-2 text-red-600 hover:bg-gray-100">
                            削除
                        </button>
                    </form>
                    <button class="w-full text-left px-3 py-2 hover:bg-gray-100">
                        通報する
                    </button>
                </div>
            </div>
        </div>

        {{-- 本文 --}}
        <div class="p-4">
            <p class="text-gray-600 mb-2">
                投稿日時：{{ $thread->created_at->format('Y年m月d日 H:i') }}
            </p>

            @if($thread->image)
                <img src="{{ asset('storage/'.$thread->image) }}"
                     class="my-4 max-h-80 rounded cursor-pointer"
                     onclick="window.open(this.src)">
            @endif

            <p class="mt-2 whitespace-pre-wrap">
                {{ $thread->body }}
            </p>

            {{-- ★ 興味ありボタン --}}
            @if($thread->enable_interest)
                <form action="{{ route('threads.interest', $thread) }}"
                      method="POST"
                      class="mt-6">
                    @csrf
                    <button type="submit"
                            class="w-full bg-pink-500 hover:bg-pink-600
                                   text-black text-xl font-bold py-4 rounded-lg">
                        ❤️ 興味あり（{{ $thread->interest_count }}）
                    </button>
                </form>
            @endif
        </div>
    </div>

    <hr class="my-6">

    {{-- コメント投稿 --}}
    <h2 class="font-bold mb-2">コメントを書く</h2>
    <form method="POST"
          action="{{ route('threads.comments.store', $thread) }}"
          class="mb-6">
        @csrf
        <textarea name="body"
                  rows="3"
                  class="w-full border rounded px-3 py-2"
                  placeholder="コメントを入力してください"
                  required></textarea>

        <button type="submit"
                class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">
            コメントする
        </button>
    </form>

    <hr class="my-6">

    {{-- コメント一覧 --}}
    <h2 class="font-bold mb-2">コメント一覧</h2>
    @forelse($comments as $comment)
        <div class="border rounded p-3 mb-4 bg-white shadow"
             x-data="{ menuOpen: false }">

            <div class="flex justify-between items-start mb-1">
                <p class="flex-1 mr-3 break-words">
                    {{ $comment->body }}
                </p>

                <div class="relative">
                    <button @click="menuOpen = !menuOpen"
                            class="text-xl font-bold px-2">
                        ︙
                    </button>
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
                        <button class="w-full text-left px-3 py-2 hover:bg-gray-100">
                            通報する
                        </button>
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

</div>
@endsection
