<section>
    <form method="post"
          action="{{ route('profile.update') }}"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <label class="block text-sm font-medium text-gray-700">名前</label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $user->name) }}"
                   class="mt-1 block w-full border rounded px-3 py-2"
                   required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">アイコン</label>
            <input type="file" name="icon" class="mt-1 block w-full">

            @if ($user->icon)
                <img src="{{ asset('storage/' . $user->icon) }}"
                     class="mt-2 w-24 h-24 rounded-full object-cover">
            @endif
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">自己紹介</label>
            <textarea name="bio"
                      rows="4"
                      class="mt-1 block w-full border rounded px-3 py-2">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">趣味</label>
            <input type="text"
                   name="hobby"
                   value="{{ old('hobby', $user->hobby) }}"
                   class="mt-1 block w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">年齢</label>
            <input type="number"
                   name="age"
                   value="{{ old('age', $user->age) }}"
                   class="mt-1 block w-full border rounded px-3 py-2">
        </div>

        <button class="px-4 py-2 bg-indigo-600 text-white rounded">
            保存
        </button>

        @if (session('status') === 'profile-updated')
            <p class="text-sm text-green-600">保存しました</p>
        @endif
    </form>
</section>
