@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-orange-50 px-4 py-12">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-white text-orange-400 rounded-full shadow-inner mb-4 border-4 border-orange-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 tracking-tight">おかえりなさい</h1>
        <p class="mt-2 text-gray-600">趣味の話で、今日も誰かとつながりましょう</p>
    </div>

    <div class="w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-orange-100">
            <div class="bg-gradient-to-r from-orange-400 to-amber-400 h-2"></div>
            
            <div class="p-8 sm:p-10">
                @if ($errors->any())
                    <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-6 rounded-r-lg text-sm text-amber-800">
                        <p class="font-bold">ご確認ください</p>
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 ml-1">
                            登録した電話番号
                        </label>
                        <input type="tel" name="phone" maxlength="11" pattern="\d{11}" 
                               class="w-full px-4 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-orange-300 focus:bg-white focus:outline-none transition-all text-lg" 
                               placeholder="例：09012345678" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 ml-1">
                            お部屋番号（3ケタ）
                        </label>
                        <input type="text" name="room_number" maxlength="3" pattern="\d{3}" 
                               class="w-full px-4 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-orange-300 focus:bg-white focus:outline-none transition-all text-lg" 
                               placeholder="101" required>
                    </div>

                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-orange-200 transition-transform active:scale-95 text-lg">
                        集会所へ入る
                    </button>
                </form>

                <div class="mt-10 border-t border-dashed border-gray-200 pt-8 text-center">
                    <p class="text-gray-500 text-sm mb-4">まだ参加されていない方へ</p>
                    <a href="{{ route('register.form') }}" class="inline-block px-8 py-3 bg-white border-2 border-orange-400 text-orange-500 font-bold rounded-full hover:bg-orange-50 transition-colors">
                        新しく仲間に入る（無料）
                    </a>
                </div>
            </div>
        </div>

        <p class="text-center mt-8 text-gray-400 text-xs tracking-widest uppercase">
            &bull; 囲碁 &bull; 盆栽 &bull; 手芸 &bull; 料理 &bull; 散歩 &bull;
        </p>
    </div>
</div>
@endsection