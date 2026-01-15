<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            プロフィール編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                <form method="POST"
                      action="{{ route('profile.update') }}"
                      enctype="multipart/form-data"
                      class="space-y-4">
                    @csrf
                    @method('PATCH')

                    {{-- アイコン --}}
                    <div>
                        <label class="block font-medium">アイコン</label>
                        <input type="file" name="icon" class="mt-1">
                    </div>

                    {{-- 自己紹介 --}}
                    <div>
                        <label class="block font-medium">自己紹介</label>
                        <textarea name="bio"
                                  class="w-full border rounded p-2"
                                  rows="4">{{ old('bio', $user->bio) }}</textarea>
                    </div>

                    {{-- 趣味 --}}
                    <div>
                        <label class="block font-medium">趣味</label>
                        <input type="text"
                               name="hobby"
                               value="{{ old('hobby', $user->hobby) }}"
                               class="w-full border rounded p-2">
                    </div>

                    {{-- 年齢 --}}
                    <div>
                        <label class="block font-medium">年齢</label>
                        <input type="number"
                               name="age"
                               value="{{ old('age', $user->age) }}"
                               class="w-full border rounded p-2">
                    </div>

                    {{-- 保存してダッシュボードへ --}}
                    <div class="mt-6">
                        <button type="submit"
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            保存してダッシュボードへ
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
