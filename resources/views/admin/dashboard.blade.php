@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
            管理者コントロールパネル
        </h2>
        <p class="mt-2 text-sm text-gray-600">システムの管理とユーザー承認をここで行います。</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <a href="{{ route('admin.pending') }}" class="group block p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md hover:border-blue-300 transition-all">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">承認待ちユーザー</h3>
                    <p class="text-sm text-gray-500 mt-1">新規登録者の確認とアクセス権限の付与を行います。</p>
                </div>
            </div>
            <div class="mt-4 text-right">
                <span class="text-blue-600 text-sm font-medium inline-flex items-center">
                    一覧を見る 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="9 5l7 7-7 7" />
                    </svg>
                </span>
            </div>
        </a>

        <a href="{{ route('admin.logs') }}" class="group block p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md hover:border-gray-300 transition-all">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 w-12 h-12 bg-gray-100 text-gray-600 rounded-lg flex items-center justify-center group-hover:bg-gray-700 group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">操作ログ</h3>
                    <p class="text-sm text-gray-500 mt-1">システム内の変更履歴や管理者の行動を確認します。</p>
                </div>
            </div>
            <div class="mt-4 text-right">
                <span class="text-gray-600 text-sm font-medium inline-flex items-center">
                    履歴を確認 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="9 5l7 7-7 7" />
                    </svg>
                </span>
            </div>
        </a>

    </div>

    <div class="mt-12 text-center">
        <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:text-gray-700 underline decoration-gray-300 underline-offset-4">
            トップページへ戻る
        </a>
    </div>
</div>
@endsection