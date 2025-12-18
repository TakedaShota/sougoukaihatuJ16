@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6">
    <div class="bg-white rounded-3xl shadow-2xl p-10 border border-gray-100">
        <div class="text-center mb-8">
            <span class="text-5xl">🤝</span>
            <h1 class="text-3xl font-black text-gray-800 mt-4">仲間を募る</h1>
            <p class="text-gray-500">あなたの好きなことを書いて、仲間を見つけましょう。</p>
        </div>

        <form action="{{ route('threads.store') }}" method="POST" class="space-y-8">
            @csrf
            <div>
                <label class="block font-black text-gray-700 mb-3 text-xl">何をしますか？（募集のタイトル）</label>
                <input type="text" name="title" required
                    class="w-full border-2 border-gray-100 rounded-2xl p-5 text-xl focus:border-orange-400 focus:ring-0 transition" 
                    placeholder="例：週末に公園で将棋をしませんか？">
            </div>

            <div>
                <label class="block font-black text-gray-700 mb-3 text-xl">詳しい内容</label>
                <textarea name="body" rows="6" required
                    class="w-full border-2 border-gray-100 rounded-2xl p-5 text-xl focus:border-orange-400 focus:ring-0 transition" 
                    placeholder="場所や時間、どんな初心者でも大丈夫かなど、優しく書いてみましょう。"></textarea>
            </div>

            <button type="submit" class="w-full bg-orange-500 text-white font-black py-5 rounded-2xl text-2xl shadow-xl hover:bg-orange-600 transform hover:scale-[1.02] transition">
                募集を広場に貼り出す
            </button>
        </form>
    </div>
</div>
@endsection