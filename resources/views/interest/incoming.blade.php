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
    <h1 class="text-2xl font-black mb-4">届いた「興味あり」</h1>

    @if (session('message'))
        <div class="bg-green-100 text-green-700 p-3 rounded-xl mb-4">
            {{ session('message') }}
        </div>
    @endif

    @forelse($requests as $r)
        <div class="bg-white p-4 rounded-xl shadow mb-3">
            <div class="font-black text-lg">{{ $r->thread->title }}</div>

            <div class="mt-2 text-sm text-gray-700">
                申請者：<span class="font-bold">{{ $r->fromUser->name }}</span>
                （部屋：{{ $r->fromUser->room_number }}）
            </div>

            <div class="mt-2 text-sm">
                状態：
                @if($r->status === 'pending')
                    <span class="font-bold text-orange-600">承認待ち</span>
                @elseif($r->status === 'approved')
                    <span class="font-bold text-green-600">承認済み（マッチ成立）</span>
                @else
                    <span class="font-bold text-gray-600">拒否</span>
                @endif
            </div>

            @if($r->status === 'pending')
                <div class="mt-3 flex gap-2">
                    <form method="POST" action="{{ route('interest.approve', $r) }}">
                        @csrf
                        <button class="px-4 py-2 rounded-xl bg-green-500 hover:bg-green-600 text-white font-bold">
                            承認
                        </button>
                    </form>

                    <form method="POST" action="{{ route('interest.reject', $r) }}">
                        @csrf
                        <button class="px-4 py-2 rounded-xl bg-gray-500 hover:bg-gray-600 text-white font-bold">
                            拒否
                        </button>
                    </form>
                </div>
            @endif
        </div>
    @empty
        <div class="bg-white p-6 rounded-xl shadow text-gray-600">
            まだ申請は届いていません。
        </div>
    @endforelse
</div>
@endsection
