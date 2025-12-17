@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow text-center">
    <h2 class="text-2xl font-bold mb-6">管理者メニュー</h2>

    <div class="space-y-4">
        <a href="{{ route('admin.pending') }}"
           class="block bg-blue-500 text-white py-2 rounded">
           承認待ちユーザー一覧
        </a>

        <a href="{{ route('admin.logs') }}"
           class="block bg-gray-500 text-white py-2 rounded">
           操作ログを見る
        </a>
    </div>
</div>
@endsection
