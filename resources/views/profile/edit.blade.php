<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            プロフィール編集
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                <!-- プロフィール更新フォーム -->
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <!-- 名前 -->
                    <div class="mt-4">
                        <x-input-label for="name" :value="__('名前')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                      value="{{ old('name', auth()->user()->name) }}" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- メール -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('メールアドレス')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                      value="{{ old('email', auth()->user()->email) }}" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- 電話番号 -->
                    <div class="mt-4">
                        <x-input-label for="phone" :value="__('電話番号')" />
                        <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                                      value="{{ old('phone', auth()->user()->phone) }}" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- 部屋番号 -->
                    <div class="mt-4">
                        <x-input-label for="room_number" :value="__('部屋番号')" />
                        <x-text-input id="room_number" class="block mt-1 w-full" type="text" name="room_number"
                                      value="{{ old('room_number', auth()->user()->room_number) }}" />
                        <x-input-error :messages="$errors->get('room_number')" class="mt-2" />
                    </div>

                    <!-- 趣味・自己紹介 -->
                    <div class="mt-4">
                        <x-input-label for="interests" :value="__('趣味・自己紹介')" />
                        <textarea id="interests" class="block mt-1 w-full" name="interests" rows="3">{{ old('interests', auth()->user()->interests) }}</textarea>
                        <x-input-error :messages="$errors->get('interests')" class="mt-2" />
                    </div>

                    <!-- アバター -->
                    <div class="mt-4">
                        <x-input-label for="avatar" :value="__('プロフィール画像')" />
                        <input id="avatar" class="block mt-1 w-full" type="file" name="avatar" />
                        <x-input-error :messages="$errors->get('avatar')" class="mt-2" />

                        @if(auth()->user()->avatar)
                            <p class="mt-2 text-sm text-gray-500">現在の画像:</p>
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="アバター" class="h-24 w-24 rounded-full mt-1">
                        @endif
                    </div>

                    <!-- 保存ボタン -->
                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            保存
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
