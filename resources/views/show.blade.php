<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">

        <h1 class="text-2xl font-bold mb-6">プロフィール</h1>

        {{-- アバター画像 --}}
        <div class="flex items-center gap-4 mb-6">
            @if (Auth::user()->avatar)
                <img 
                    src="{{ asset('storage/' . Auth::user()->avatar) }}" 
                    class="w-24 h-24 rounded-full object-cover border"
                >
            @else
                <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                    No Image
                </div>
            @endif

            <div>
                <p class="text-xl font-semibold">
                    {{ Auth::user()->display_name ?? '未設定' }}
                </p>
                <p class="text-gray-500 text-sm">
                    {{ Auth::user()->email }}
                </p>
            </div>
        </div>

        <div class="mt-6">
            <a 
                href="{{ route('profile.edit') }}" 
                class="text-indigo-600 hover:text-indigo-800 underline"
            >
                プロフィールを編集する
            </a>
        </div>
    </div>
</x-app-layout>
