<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ダッシュボード
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-8 text-center">

                {{-- アイコン欄（最小サイズ） --}}
                <div class="flex justify-center mb-6">
                    @if (Auth::user()->icon)
                        <div class="w-24 h-24 rounded-full overflow-hidden border border-gray-300">
                            <img
                                src="{{ asset('storage/' . Auth::user()->icon) }}"
                                alt="プロフィールアイコン"
                                class="w-full h-full object-cover"
                            >
                        </div>
                    @else
                        <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 text-sm">
                            No Image
                        </div>
                    @endif
                </div>

                {{-- 名前 --}}
                <h3 class="text-2xl font-bold mb-2">
                    {{ Auth::user()->name }}
                </h3>

                {{-- 自己紹介 --}}
                @if (Auth::user()->bio)
                    <p class="text-gray-700 mb-4">
                        {{ Auth::user()->bio }}
                    </p>
                @else
                    <p class="text-gray-400 mb-4">
                        自己紹介はまだ設定されていません
                    </p>
                @endif

                {{-- プロフィール情報 --}}
                <div class="text-gray-600 space-y-1">
                    @if (Auth::user()->hobby)
                        <p>🎯 趣味：{{ Auth::user()->hobby }}</p>
                    @endif

                    @if (Auth::user()->age)
                        <p>🎂 年齢：{{ Auth::user()->age }}歳</p>
                    @endif
                </div>

                {{-- 編集ボタン --}}
                <div class="mt-6">
                    <a
                        href="{{ route('profile.edit') }}"
                        class="inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    >
                        プロフィール編集
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
