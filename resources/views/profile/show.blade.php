<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            プロフィール表示
        </h2>
    </x-slot>

    <div class="p-6">
        <p><strong>名前：</strong> {{ Auth::user()->name }}</p>
        <p><strong>Email：</strong> {{ Auth::user()->email }}</p>
    </div>
</x-app-layout>
