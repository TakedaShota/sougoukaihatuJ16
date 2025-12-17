<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ダッシュボード
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg p-8">

                <h3 class="text-2xl font-bold mb-2">
                    ようこそ、{{ Auth::user()->name }} さん！
                </h3>

                <p class="text-gray-600 mb-6">
                    このページは承認されたユーザーだけが閲覧できます。
                </p>

                <h3 class="text-xl font-bold mb-6">メニュー</h3>

                <div class="grid grid-cols-3 gap-6">

                    <!-- 掲示板 -->
                    <a href="{{ route('threads.index') }}"
                       class="text-center bg-blue-500 text-white py-4 rounded-xl shadow hover:bg-blue-600 transition">
                        掲示板
                    </a>

                    <!-- グループチャット（仮） -->
                    <a href="#"
                       class="text-center bg-green-500 text-white py-4 rounded-xl shadow hover:bg-green-600 transition">
                        グループチャット
                    </a>

                    <!-- プロフィール -->
                    <a href="{{ route('profile.edit') }}"
                       class="text-center bg-gray-700 text-white py-4 rounded-xl shadow hover:bg-gray-800 transition">
                        プロフィール
                    </a>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
