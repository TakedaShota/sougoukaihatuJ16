@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-4">

    <h1 class="text-2xl font-bold mb-4">掲示板一覧</h1>

    <!-- スレッド作成ボタン -->
    <div class="mb-4">
        <a href="{{ route('threads.create') }}" class="bg-green-500 text-black px-4 py-2 rounded">
            新しいスレッドを作成
        </a>
    </div>

    @foreach($threads as $thread)
        <div class="mb-4 p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ $thread->title }}
            </h2>
            
            <p class="mt-3 text-gray-600 leading-relaxed">
                {{ Str::limit($thread->body, 120) }}
            </p>

            <a href="{{ route('threads.show', $thread) }}"
               class="inline-block mt-4 text-blue-600 font-semibold hover:underline">
                詳細を見る →
            </a>
        </div>
    @endforeach

</div>
@endsection
