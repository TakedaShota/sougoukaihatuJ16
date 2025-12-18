@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-gray-50 border-b px-6 py-4">
            <h2 class="text-xl font-semibold text-gray-800">操作ログ一覧</h2>
        </div>

        <div class="p-6">
            @if($logs && $logs->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">日時</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">アクション</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($logs as $log)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $log->created_at->format('Y/m/d H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $log->action }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if(method_exists($logs, 'links'))
                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-10">
                    <p class="text-gray-500">ログはまだありません。</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection