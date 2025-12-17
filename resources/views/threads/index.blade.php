@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">掲示板</h1>

    @forelse ($threads as $thread)
        <div class="border-b py-3">
            <h2 class="font-semibold">{{ $thread->title }}</h2>
            <p class="text-sm text-gray-600">
                {{ $thread->created_at->format('Y-m-d H:i') }}
            </p>
        </div>
    @empty
        <p>まだ投稿はありません。</p>
    @endforelse
</div>
@endsection
