<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            プロフィール
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <h3 class="text-lg font-bold mb-4">基本情報</h3>

                <p><strong>名前：</strong> {{ Auth::user()->name }}</p>
                <p><strong>メール：</strong> {{ Auth::user()->email }}</p>

                <hr class="my-4">

                <h3 class="text-lg font-bold mb-4">プロフィール</h3>

                <p><strong>年齢：</strong> {{ Auth::user()->age ?? '未設定' }}</p>
                <p><strong>性別：</strong> {{ Auth::user()->gender ?? '未設定' }}</p>
                <p><strong>趣味：</strong> {{ Auth::user()->hobby ?? '未設定' }}</p>
                <p><strong>団地名：</strong> {{ Auth::user()->residence ?? '未設定' }}</p>
                <p><strong>ひとこと：</strong><br>
                    {{ Auth::user()->bio ?? '未設定' }}
                </p>

            </div>
        </div>
    </div>
</x-app-layout>
