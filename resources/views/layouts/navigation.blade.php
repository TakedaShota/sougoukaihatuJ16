<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg" class="block h-9 w-auto fill-current text-gray-800">
                            <path d="M305.8 81.125C305.77 80.995 305.69 80.885 305.65 80.755C305.56 80.525 305.49 80.285 305.37 80.075C305.29 79.935 305.17 79.815 305.07 79.685C304.94 79.515 304.83 79.325 304.68 79.175C304.55 79.045 304.39 78.955 304.25 78.845C304.09 78.715 303.95 78.575 303.77 78.475L251.32 48.275C249.97 47.495 248.31 47.495 246.96 48.275L194.51 78.475C194.33 78.575 194.19 78.725 194.03 78.845C193.89 78.955 193.73 79.045 193.6 79.175C193.45 79.325 193.34 79.515 193.21 79.685C193.11 79.815 192.99 79.935 192.91 80.075C192.79 80.285 192.71 80.525 192.63 80.755C192.58 80.875 192.51 80.995 192.44 81.125C192.38 81.245 192.33 81.355 192.29 81.475C192.21 81.715 192.17 81.955 192.17 82.195V142.195C192.17 143.835 193.5 145.165 195.14 145.165H245.47V165.165H195.14C193.5 165.165 192.17 166.495 192.17 168.135V228.135C192.17 228.375 192.21 228.615 192.29 228.855C192.33 228.975 192.38 229.085 192.44 229.205C192.51 229.335 192.58 229.455 192.63 229.575C192.71 229.805 192.79 230.045 192.91 230.255C192.99 230.395 193.11 230.515 193.21 230.645C193.34 230.815 193.45 231.005 193.6 231.155C193.73 231.285 193.89 231.375 194.03 231.485C194.19 231.605 194.33 231.755 194.51 231.855L246.96 262.055C247.63 262.445 248.37 262.635 249.11 262.635C249.85 262.635 250.59 262.445 251.26 262.055L303.71 231.855C303.89 231.755 304.03 231.605 304.19 231.485C304.33 231.375 304.49 231.285 304.62 231.155C304.77 231.005 304.88 230.815 305.01 230.645C305.11 230.515 305.23 230.395 305.31 230.255C305.43 230.045 305.51 229.805 305.59 229.575C305.64 229.455 305.71 229.335 305.78 229.205C305.84 229.085 305.89 228.975 305.93 228.855C306.01 228.615 306.05 228.375 306.05 228.135V82.195C306.05 81.955 306.01 81.715 305.93 81.475C305.89 81.355 305.84 81.245 305.8 81.125Z" />
                        </svg>
                    </a>
                </div>

                @auth
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    {{-- 
                        ▼▼▼ ここを全部空っぽにしました ▼▼▼
                        ダッシュボード、掲示板、届いた興味あり、送った興味あり、マッチ成立
                        これらすべてのメニューリンクを削除しました。
                    --}}
                </div>
                @endauth
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white">
                            {{ auth()->user()->name }}
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            プロフィール編集
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                ログアウト
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 text-gray-400">
                    ☰
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': ! open }" class="hidden sm:hidden">
        @auth
        <div class="pt-2 pb-3 space-y-1">
            {{-- 
                ▼▼▼ スマホ用メニューも全部空っぽにしました ▼▼▼
            --}}
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 font-medium text-gray-800">
                {{ auth()->user()->name }}
            </div>

            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        ログアウト
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>