@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4 sm:p-6 min-h-screen">
    <nav class="mb-8">
        <a href="{{ route('threads.index') }}" class="text-orange-600 font-bold flex items-center hover:underline">
            ← みんなの募集一覧へ戻る
        </a>
    </nav>

    <div class="bg-white rounded-3xl shadow-lg border border-orange-50 overflow-hidden mb-10">
        <div class="bg-gradient-to-r from-orange-400 to-yellow-400 h-3"></div>
        <div class="p-8">
            <h1 class="text-3xl font-black text-gray-800 mb-6 leading-tight">{{ $thread->title }}</h1>
            
            <div class="bg-orange-50 rounded-2xl p-6 mb-8 text-xl text-gray-700 leading-loose whitespace-pre-wrap border-l-8 border-orange-200">
                {{ $thread->body }}
            </div>

            <div class="flex items-center justify-between text-gray-400">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-3 text-2xl">👤</div>
                    <span class="font-bold text-gray-600">募集主さん</span>
                </div>
                <span>{{ $thread->created_at->format('Y/m/d') }}</span>
            </div>
        </div>
    </div>

    {{-- コメント・参加希望セクション --}}
    <section class="space-y-6">
        <div class="flex items-center justify-between">
            <h3 class="text-2xl font-bold text-gray-800">
                参加希望・お問い合わせ
            </h3>
        </div>

        {{-- 返信フォーム --}}
        <div class="bg-white rounded-2xl p-6 border-2 border-orange-400 shadow-md">
            <form action="{{ route('threads.comments.store', $thread) }}" method="POST">
                @csrf
                <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                <label class="block text-gray-700 font-black text-lg mb-3">「一緒にやりたい！」とお返事してみる</label>
                <textarea name="body" rows="3" placeholder="例：私も囲碁が好きです！ぜひ一度ご一緒させてください。" required
                    class="w-full px-4 py-4 rounded-xl border-gray-200 focus:ring-orange-500 shadow-inner text-lg mb-4"></textarea>
                <button type="submit" class="w-full bg-orange-500 text-white font-black py-4 rounded-xl text-xl shadow-lg hover:bg-orange-600 transition">
                    お返事（参加希望）を送る
                </button>
            </form>
        </div>

        {{-- 交流ログ --}}
        <div class="space-y-4">
            @foreach ($thread->comments as $comment)
                <div class="bg-white rounded-2xl p-5 border border-gray-100 flex gap-4">
                    <div class="shrink-0 text-3xl">🙋‍♂️</div>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <span class="font-bold text-gray-800">{{ $comment->user->name ?? '名無しさん' }}</span>
                            <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-700 text-lg">{{ $comment->body }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection