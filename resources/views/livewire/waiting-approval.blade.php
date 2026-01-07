<div>
    {{-- このコンポーネントは承認待ちのチェック専用 --}}
    {{-- JS で 3 秒ごとに Livewire の checkApproval メソッドを呼び出す --}}
    <script>
        setInterval(() => {
            Livewire.emit('checkApproval');
        }, 3000);
    </script>
</div>
