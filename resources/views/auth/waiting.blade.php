@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow text-center max-w-md w-full">
        <h2 class="text-xl font-bold mb-4">承認待ち</h2>
        <p class="text-gray-600 mb-6">
            管理者が承認すると自動で画面が切り替わります
        </p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-sm text-gray-400 hover:text-gray-600">
                ログアウト
            </button>
        </form>
    </div>
</div>

<script>
(() => {
    const CHECK_INTERVAL = 3000;
    let timer = null;

    async function checkApproval(force = false) {
        try {
            const res = await fetch('/api/check-approved', {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin'
            });

            if (!res.ok) return;

            const data = await res.json();

            if (data.approved) {
                window.location.replace('/threads');
            }
        } catch (e) {}
    }

    // 通常ポーリング
    timer = setInterval(() => checkApproval(false), CHECK_INTERVAL);

    // タブがアクティブになった瞬間に即チェック（←これが超重要）
    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'visible') {
            checkApproval(true);
        }
    });

    // フォーカス復帰でもチェック
    window.addEventListener('focus', () => {
        checkApproval(true);
    });

    // 初回チェック
    checkApproval(true);
})();
</script>
@endsection
