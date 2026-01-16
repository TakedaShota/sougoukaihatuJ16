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

            {{-- 削除ボタン（投稿者のみ） --}}
            @auth
                @if(Auth::id() === $thread->user_id)
                    <form action="{{ route('threads.destroy', $thread) }}"
                          method="POST"
                          onsubmit="return confirm('本当に削除しますか？')"
                          class="mb-6">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 font-bold hover:underline">
                            🗑 投稿を削除
                        </button>
                    </form>
                @endif
            @endauth

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

            {{-- ❤️ 興味あり --}}
            @if($thread->enable_interest)
                <div class="mt-6">
                    @auth
                        <button
                            id="interest-btn"
                            type="button"
                            data-url="{{ route('threads.interest', $thread) }}"
                            class="flex items-center gap-2 select-none"
                        >
                            <svg id="heart-icon"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                class="w-8 h-8 transition-colors duration-200
                                    {{ $hasInterested ? 'text-pink-500' : 'text-black' }}"
                                fill="{{ $hasInterested ? 'currentColor' : 'none' }}"
                                stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.682 4.318 12.682a4.5 4.5 0 010-6.364z" />
                            </svg>

                            <span id="interest-count" class="text-base text-gray-700">
                                {{ $thread->interest_count }}
                            </span>
                        </button>
                    @else
                        <p class="text-gray-400">
                            ❤️ {{ $thread->interest_count }}（ログインすると押せます）
                        </p>
                    @endauth
                </div>
            @endif
        </div>
    </div>

    {{-- コメント投稿 --}}
    @auth
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
    @endauth

    {{-- コメント一覧 --}}
    <section class="space-y-4">
        @forelse($comments as $comment)
            <div class="bg-white rounded-2xl p-5 border shadow">
                <p class="text-lg break-words">{{ $comment->body }}</p>
                <small class="text-gray-500">
                    {{ $comment->created_at->format('Y/m/d H:i') }}
                </small>
            </div>
        @empty
            <p class="text-gray-500">まだコメントはありません。</p>
        @endforelse
    </section>

</div>

{{-- ❤️ Ajax --}}
<script>
document.getElementById('interest-btn')?.addEventListener('click', async () => {
    const btn = document.getElementById('interest-btn');
    const url = btn.dataset.url;
    const token = document.querySelector('meta[name="csrf-token"]').content;

    const res = await fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
        },
    });

    if (!res.ok) return;

    const data = await res.json();

    const heart = document.getElementById('heart-icon');
    const count = document.getElementById('interest-count');

    if (data.liked) {
        heart.classList.remove('text-black');
        heart.classList.add('text-pink-500');
        heart.setAttribute('fill', 'currentColor');
    } else {
        heart.classList.remove('text-pink-500');
        heart.classList.add('text-black');
        heart.setAttribute('fill', 'none');
    }

    count.textContent = data.count;
});
</script>
@endsection
