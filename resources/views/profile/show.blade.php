@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-4 sm:p-8 min-h-screen md:text-lg">
    
    {{-- 戻るボタン --}}
    <div class="mb-8">
        <a href="javascript:history.back()" class="text-gray-500 hover:text-orange-500 flex items-center text-lg font-bold">
            <span class="mr-2 text-2xl">←</span> 元の画面に戻る
        </a>
    </div>

    <div class="bg-white rounded-[2rem] shadow-xl p-6 md:p-12 border-2 border-orange-50">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-3">プロフィール</h1>
        </div>

        {{-- 1. プロフィール画像 --}}
        <div class="mb-8 text-center">
            <div class="flex justify-center mb-6">
                @if($user->image)
                    <img src="{{ asset('storage/' . $user->image) }}" 
                            class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover border-4 border-orange-200 shadow-md">
                @else
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-full bg-orange-50 flex items-center justify-center text-6xl text-orange-300 border-4 border-orange-200 shadow-inner">
                        👤
                    </div>
                @endif
            </div>
            
            {{-- お名前 --}}
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
                {{ $user->name }}
            </h2>
        </div>

        <hr class="border-gray-200 my-8">

        {{-- 2. 自己紹介 --}}
        <div class="mb-10">
            <label class="block text-gray-500 font-bold mb-3 text-sm">自己紹介・趣味</label>
            <div class="bg-orange-50/50 rounded-2xl p-6 text-gray-800 leading-loose whitespace-pre-wrap border border-orange-100 min-h-[150px]">
                @if($user->introduction)
                    {{ $user->introduction }}
                @else
                    <span class="text-gray-400">（自己紹介はまだ登録されていません）</span>
                @endif
            </div>
        </div>

        {{-- ボタンエリア --}}
        @if(auth()->id() === $user->id)
            <div class="text-center">
                <a href="{{ route('profile.edit') }}" 
                   class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-full shadow transition">
                    編集する
                </a>
            </div>
        @endif

    </div>
</div>
@endsection