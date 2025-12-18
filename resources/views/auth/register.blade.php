@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-orange-50 px-4 py-12">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-white text-green-500 rounded-full shadow-inner mb-4 border-4 border-green-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 tracking-tight">新しい仲間として迎える</h1>
        <p class="mt-2 text-gray-600">あなたの趣味や好きなことを、みんなに教えてください</p>
    </div>

    <div class="w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-orange-100">
            <div class="bg-gradient-to-r from-green-400 to-emerald-400 h-2"></div>
            
            <div class="p-8 sm:p-10">
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
                        <ul class="list-disc list-inside text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1 ml-1">お名前（ニックネーム可）</label>
                        <p class="text-xs text-gray-500 mb-2 ml-1">※本名でなくても大丈夫です。呼ばれたい名前を入力してください。</p>
                        <input type="text" name="name" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-green-300 focus:bg-white focus:outline-none transition-all" placeholder="例：山ちゃん、ひろこ" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1 ml-1">電話番号</label>
                            <input type="tel" name="phone" maxlength="11" pattern="\d{11}" 
                                   class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-green-300 focus:bg-white focus:outline-none transition-all" 
                                   placeholder="09012345678" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1 ml-1">部屋番号</label>
                            <input type="text" name="room_number" maxlength="3" pattern="\d{3}" 
                                   class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-green-300 focus:bg-white focus:outline-none transition-all" 
                                   placeholder="101" required>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-gray-100">
                        <label class="block text-sm font-semibold text-gray-700 mb-1 ml-1">パスワード</label>
                        <input type="password" name="password" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-green-300 focus:bg-white focus:outline-none transition-all" placeholder="忘れないようにメモしてくださいね" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1 ml-1">パスワード（確認用）</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-green-300 focus:bg-white focus:outline-none transition-all" placeholder="もう一度入力してください" required>
                    </div>

                    <button type="submit" class="w-full mt-4 bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-green-100 transition-transform active:scale-95 text-lg">
                        仲間に入る
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <a href="{{ route('login') }}" class="text-gray-500 text-sm hover:text-orange-500 transition-colors">
                        すでに登録されている方は <span class="underline font-bold text-orange-400">こちらからログイン</span>
                    </a>
                </div>
            </div>
        </div>
        
        <p class="text-center mt-6 text-gray-500 text-sm italic">
            「同じ屋根の下、新しい楽しみを見つけませんか？」
        </p>
    </div>
</div>
@endsection